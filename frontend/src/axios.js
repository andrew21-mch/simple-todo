import axios from 'axios';

axios.defaults.baseURL = 'https://api.test.nfonandrew.info';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';

export default axios;
