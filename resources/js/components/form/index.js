import React from 'react';
import ReactDOM from 'react-dom';
import * as variables from './variables';
import DemoBar from './demobar';
import FormBuilders from './ReactFormBuilder';

if (document.getElementById('react-form-builder')) {
    const url = document.getElementById('react-form-builder').getAttribute('url');
    const saveUrl = document.getElementById('react-form-builder').getAttribute('saveUrl');
    ReactDOM.render(<FormBuilders.ReactFormBuilder variables={variables} url={url} saveUrl={saveUrl} />, document.getElementById('react-form-builder'));
}

if (document.getElementById('demo-bar')) {
    const users = document.getElementById('demo-bar').getAttribute('users');
    const user_id = document.getElementById('demo-bar').getAttribute('user_id');
    const save_url = document.getElementById('demo-bar').getAttribute('save_url');
    const edit_mode = document.getElementById('demo-bar').getAttribute('edit_mode');
    ReactDOM.render(
        <DemoBar variables={variables} users={users} user_id={user_id} save_url={save_url} edit_mode={edit_mode}/>,
        document.getElementById('demo-bar'),
    );
}