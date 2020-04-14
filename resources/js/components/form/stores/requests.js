import fetch from 'isomorphic-fetch';
import Cookies from 'js-cookie';

let token = Cookies.get('XSRF-TOKEN');
const headers = {
  'Accept': 'application/json',
  'Content-Type': 'application/json; charset=utf-8',
  'Authorization': 'Bearer ' + token
};

export function post(url, data) {
  return fetch(url, {
    credentials: 'include',
    mode: 'cors',
    method: 'POST',
    headers,
    body: JSON.stringify(data),
  }).then(response => response);
}

export function get(url) {
  return fetch(url, {
    credentials: 'include',
    mode: 'cors',
    method: 'GET',
    headers,
  }).then(response => response.json());
}
