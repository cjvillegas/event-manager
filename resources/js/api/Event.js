import axios from 'axios'

export default {
	saveEvent(postData) {
		return axios.post(`/event`, postData)
	},

	fetchEvents(postData) {
		return axios.post(`/event/fetch-events`, postData)
	}
}