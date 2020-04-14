import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { FaPen, FaSave, FaThumbsUp, FaExclamationCircle } from 'react-icons/fa';
import Toast from 'react-bootstrap/Toast'

export default class ProfileFormSnd extends React.Component {

    constructor(props) {
        super(props);
        this.data = JSON.parse(props.data);
        this.state = {
            user: this.data.user,
            profile: this.data.profile,
            token: '',
            isEdit: false,
            showToast: false,
            toastText: '',
            isSuccess: false,
        }
    }

    componentDidMount() {
        this._setFormCsrfToken();
        const _this = this;

        window.onresize = function (event) {
            _this._setHeightSameAsWidth()
        }
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

    editForm = (event) => {
        this.setState({
            isEdit: true
        })
    }

    saveForm = (event) => {
        if (this.data.user != this.state.user || this.data.profile != this.state.profile) {
            document.getElementById("profile-form-fst").submit();
        }
        this.setState({
            isEdit: false
        })
    }

    onImageChange(token) {
        const imgFile = document.getElementById("avatar").files[0];
        const formData = new FormData();
        formData.append('imgFileName', imgFile.name);
        formData.append('imgFile', imgFile);
        const settings = { headers: { 'X-CSRF-TOKEN': token, 'content-type': 'multipart/form-data', 'accept': 'application/json', } };
        const _this = this;
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
                    });

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

    onInputChange(value, key) {
        this.setState({
            user: {
                ...this.state.user,
                [key]: value
            }
        });
    }

    render() {
        const profileImgUrl = this.state.profile ? this.state.profile.avatar : '/images/no-user.png';
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
                            <div className="profile-detail mt-4">
                                <p className="mb-0" style={styles.textUserName}>{this.state.user.name}</p>
                                <p className="mb-0 mt-1" style={styles.textUserEmail}>{this.state.user.email}</p>
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
                                        <input type="hidden" name="avatar_url" id="avatar_url" value={this.state.profile ? this.state.profile.avatar : ''} />
                                        <input type="hidden" name="form" value="fst" />
                                    </div>
                                </div>
                                <div className="profile-detail mt-4">
                                    <input type="text" className="form-control text-center" name="name" id="name" value={this.state.user.name} onChange={e => this.onInputChange(e.target.value, 'name')} required autoFocus />
                                    <input type="email" className="form-control text-center mt-1" name="email" id="email" value={this.state.user.email} onChange={e => this.onInputChange(e.target.value, 'email')} required />
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

if (document.getElementById('react-profile-form-second')) {
    const data = document.getElementById('react-profile-form-second').getAttribute('data');
    const action_url = document.getElementById('react-profile-form-second').getAttribute('action_url');
    ReactDOM.render(<ProfileFormSnd data={data} action_url={action_url} />, document.getElementById('react-profile-form-second'));
}