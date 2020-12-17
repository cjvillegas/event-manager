import axios from 'axios'

export default {
	/**
	 * Handle API call for logging in
	 * 
	 * @param postData <object> - post information {email, password, remember}
	 *
	 * @return <Promise>
	 */
	login(postData) {
		return axios.post('/login', postData)
	}
}