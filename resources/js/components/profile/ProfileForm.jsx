import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { FaPen, FaSave, FaThumbsUp, FaExclamationCircle } from 'react-icons/fa';
import Toast from 'react-bootstrap/Toast'

export default class ProfileForm extends React.Component {

    constructor(props) {
        super(props);
        this.data = JSON.parse(props.data);
        this.state = {
            user: this.data.user,
            profile: this.data.profile,
            provinces: this.data.provinces,
            token: '',
            isEdit: false,
            showToast: false,
            toastText: '',
            isSuccess: false,
            districts: {},
            uploading: false,
        }
    }

    componentDidMount() {
        this._setFormCsrfToken();
        this._insertProvinces();

        const _this = this;
        window.onresize = function (event) {
            _this._setHeightSameAsWidth()
        }

        this._insertDistricts(this.data.districts_of_user_province)
    }

    _setFormCsrfToken = () => {
        this.state.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    _setHeightSameAsWidth = () => {
        const avatarWidth = document.querySelector(".card-body.active .avatar-wrapper .avatar").offsetWidth;
        const avatarElements = document.querySelectorAll(".avatar-wrapper .avatar")
        for (let i = 0; i < avatarElements.length; i++) {
            const element = avatarElements[i];
            element.style.height = avatarWidth + 'px';
        }
    }

    _insertProvinces = () => {
        if(this.state.user.role != 'superadmin') {
            const provinces = this.state.provinces;
            let province_id = null;
            if (Object.keys(this.state.profile.province).length > 0) {
                province_id = this.state.profile.province.id
            }
            let _str = '<option value=0><strong>Select Your Province</strong></option>';
            for (let i = 0; i < provinces.length; i++) {
                const element = provinces[i];
                const selected = '';
                if (province_id && province_id == provinces[i].id) {
                    selected = 'selected';
                }
                _str = _str + '<option value="' + element.id + '" ' + selected + '>' + element.name + '</option>';
            }
            document.getElementById('province').innerHTML = _str;
        } else {
            return
        }
    }

    _insertDistricts = (districts) => {
        if(this.state.user.role == 'supervisor') {
            let _str = '';
            let district_id = null;
            console.log(districts);
            if(districts.length) {
                if (Object.keys(this.state.profile.district).length > 0) {
                    district_id = this.state.profile.district.id
                }
                _str = _str + '<option value=0>Choose Your District</option>';
                districts.map(district => {
                    const selected = district_id == district.id ? 'selected' : '';
                    _str = _str + '<option value="'+ district.id +'" '+ selected +'>'+ district.name +'</option>';
                });
            }else {
                _str = '<option disabled></option>';
            }

            document.getElementById('district').innerHTML = _str;
        }
    }

    editForm = (event) => {
        this.setState({
            isEdit: true
        })
    }

    saveForm = (event) => {
        if ( this.data.user != this.state.user || this.data.profile != this.state.profile || (this.state.profile.province && this.state.profile.province.id ) ) {
            document.getElementById("profile-form-fst").submit();
        }

        this.setState({
            isEdit: false
        })
    }

    onImageChange = (token) => {
        const imgFile = document.getElementById("avatar").files[0];
        const formData = new FormData();
        formData.append('imgFileName', imgFile.name);
        formData.append('imgFile', imgFile);
        const settings = { headers: { 'X-CSRF-TOKEN': token, 'content-type': 'multipart/form-data', 'accept': 'application/json', } };
        const _this = this;
        this.toggleUploading();
        axios.post('/ajax/avatar_upload', formData, settings)
            .then(function (response) {
                if (response.data.result > 0) {
                    const file_name = response.data.file_name;
                    _this.setState({
                        toastText: 'Successful upload!',
                        showToast: true,
                        isSuccess: true,
                        profile: {
                            ..._this.state.profile,
                            avatar: response.data.file_name
                        }
                    }, () => {
                        document.getElementById('nav-profile-avatar').src = response.data.file_name;
                    });
                    setTimeout(() => {
                        _this.toggleUploading(); 
                    }, 200);

                } else if (response.data.result == 0) {
                    _this.setState({
                        toastText: 'Something went wrong! Try again please.',
                        showToast: true,
                    });
                } else {
                    _this.setState({
                        toastText: 'Invaild file type!',
                        showToast: true,
                    });
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    onInputChange = (value, key) => {
        this.setState({
            user: {
                ...this.state.user,
                [key]: value
            }
        });
    }

    onProvinceChange(e) {
        const province_id = parseInt(e.target.value);
        if(province_id > 0) {
            this.setState({
                profile: {
                    ...this.state.profile,
                    province: {
                        ...this.state.profile.province,
                        id: province_id,
                        name: this.state.provinces[province_id - 1].name
                    }
                }
            }, () => {
                if(this.state.districts[province_id]) {
                    this._insertDistricts(this.state.districts[province_id]);
                }else{
                    const settings = { headers: { 'X-CSRF-TOKEN': this.state.token} };
                    const _this = this;
                    if(document.getElementById("district")) {
                        axios.post('/ajax/get_districts', {province_id: province_id}, settings)
                        .then(function (response) {
                            _this.setState({
                                districts: {
                                    ..._this.state.districts,
                                    [province_id]: response.data
                                }
                            })
                            _this._insertDistricts(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                }
            });
            
        }else {
            this.setState({
                profile: {
                    ...this.state.profile,
                    province: {},
                    district: {}
                }
            }, () => {
                this._insertDistricts([]);
            });
            
        }
    }

    onDistrictChange = (e) => {
        const district_id = e.target.value
        if(parseInt(district_id) > 0) {
            this.setState({
                profile: {
                    ...this.state.profile,
                    district: {
                        ...this.state.profile.district,
                        id: district_id,
                        state_id: this.state.profile.province.id
                    }
                }
            });
        }else{
            this.setState({
                profile: {
                    ...this.state.profile,
                    district: []
                }
            });
        }
    }

    toggleUploading() {
        this.setState({
            uploading: !this.state.uploading
        }, () => {
            document.getElementById('uploading').classList.toggle("d-none");
        });
    }

    render() {
        const profileImgUrl = this.state.profile.avatar ? this.state.profile.avatar : '/images/no-user.png';
        const styles = {
            avatar: {

            },
            profileImg: {
                backgroundImage: 'url(' + profileImgUrl + ')',
            },
            profileImgLabel: {
                backgroundImage: 'url(' + profileImgUrl + ')',
                cursor: 'pointer'
            },
            btnContainer: {
                position: 'absolute',
                top: 0,
                right: 0,
                zIndex: 10,
            },
            editBtn: {
                float: 'right',
                marginTop: 15,
                marginRight: 15,
                paddingTop: 8,
                paddingBottom: 8,
                borderRadius: 21,
                boxShadow: '0 0 3px rgba(0,0,0,0.3)',
            },
            toastWrapper: {
                position: 'fixed',
                top: 100,
                right: 25,
                zIndex: 10000,
            },
            textUserName: {
                textAlign: 'center',
                padding: '0.45rem 0.75rem',
                fontSize: '1rem',
                color: '#1c2d41',
            },
            textUserEmail: {
                textAlign: 'center',
                padding: '0.45rem 0.75rem',
                fontSize: '1rem',
                fontStyle: 'italic',
            },

        }
        return (
            <div>
                <div className="card-profile">
                    <div className="card position-relative">
                        <div style={styles.btnContainer}>
                            {this.state.isEdit ?
                                <button className="btn btn-primary" style={styles.editBtn} onClick={this.saveForm}><FaSave /></button>
                                :
                                <button className="btn" style={styles.editBtn} onClick={this.editForm}><FaPen /></button>
                            }
                        </div>
                        <div className="ribb ribb-top-left"><span>{this.state.user.role ? this.state.user.role : 'No Role'}</span></div>
                        <div className={this.state.isEdit ? 'card-body' : 'card-body active'}>
                            <div className="avatar-wrapper">
                                <div className="avatar">
                                    <div className="profile-img" style={styles.profileImg}>
                                    </div>
                                </div>
                            </div>
                            <div className="profile-detail">
                                <p className="mb-0" style={styles.textUserName}>{this.state.user.name}</p>
                                <p className="mb-0 mt-1" style={styles.textUserEmail}>{this.state.user.email}</p>
                                {this.state.user.role == 'manager' ?
                                    <p className="mb-0 mt-1" style={styles.textUserName}>
                                        Province:&nbsp;
                                        {
                                            Object.keys(this.state.profile.province).length > 0 ? this.state.profile.province.name : ' None'
                                        }
                                    </p>
                                    : ''
                                }
                                {this.state.user.role == 'supervisor' ?
                                    <div>
                                        <p className="mb-0 mt-1" style={styles.textUserName}>
                                            Province:&nbsp;
                                            {
                                                Object.keys(this.state.profile.province).length > 0 ? this.state.profile.province.name : ' None'
                                            }
                                        </p>
                                        <p className="mb-0 mt-1" style={styles.textUserName}>
                                            District:&nbsp;
                                            {
                                                Object.keys(this.state.profile.district).length > 0 ? this.state.profile.district.name : ' None'
                                            }
                                        </p>
                                    </div>
                                    : ''
                                }

                            </div>
                        </div>
                        <div className={this.state.isEdit ? 'card-body active' : 'card-body'}>
                            <form action={this.props.action_url} id="profile-form-fst" encType="multipart/form-data" method="post">
                                <input type="hidden" name="_token" value={this.state.token} />
                                <div className="avatar-wrapper">
                                    <div className="avatar">
                                        <label htmlFor="avatar" className="profile-img" style={styles.profileImgLabel} title="Click To Change Image!">
                                        </label>
                                        <input type="file" className="d-none" name="avatar" id="avatar" onChange={e => this.onImageChange("" + this.state.token)} />
                                        <input type="hidden" name="avatar_url" id="avatar_url" value={this.state.profile.avatar ? this.state.profile.avatar : ''} />
                                        <input type="hidden" name="form" value="fst" />
                                    </div>
                                </div>
                                <div className="profile-detail">
                                    <input type="text" className="form-control text-center" name="name" id="name" value={this.state.user.name} onChange={e => this.onInputChange(e.target.value, 'name')} required autoFocus />
                                    <input type="email" className="form-control text-center mt-1" name="email" id="email" value={this.state.user.email} onChange={e => this.onInputChange(e.target.value, 'email')} required />
                                    {
                                        this.state.user.role == 'superadmin' ? '' :
                                            this.state.user.role == 'manager' ?
                                                <select className="form-control mt-1" name="province" id="province" onChange={e => this.onProvinceChange(e)} required></select> :
                                                this.state.user.role == 'supervisor' ?
                                                    <div>
                                                        <select className="form-control mt-1" name="province" id="province" onChange={e => this.onProvinceChange(e)}></select>
                                                        <select className="form-control mt-1" name="district" id="district" onChange={e => this.onDistrictChange(e)}>
                                                            <option disabled>Choose Your District</option>
                                                        </select>
                                                    </div> : ''
                                    }
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style={styles.toastWrapper}>
                    <Toast onClose={() => this.setState({ showToast: false, toastText: '', isSuccess: false })} show={this.state.showToast} delay={5000} autohide>

                        <Toast.Body>
                            <strong className="mr-2">
                                {!this.state.isSuccess ?
                                    <FaExclamationCircle size="20" />
                                    :
                                    <FaThumbsUp size="20" />
                                }
                            </strong>
                            {this.state.toastText}
                        </Toast.Body>
                    </Toast>
                </div>
            </div>
        );
    };
}

if (document.getElementById('react-profile-form-first')) {
    const data = document.getElementById('react-profile-form-first').getAttribute('data');
    const action_url = document.getElementById('react-profile-form-first').getAttribute('action_url');
    ReactDOM.render(<ProfileForm data={data} action_url={action_url} />, document.getElementById('react-profile-form-first'));
}