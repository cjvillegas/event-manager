export default {
	data() {
		return {
			retreiving: false, 
			filters: {
				daterange: [
					moment().startOf('month').format('YYYY-MM-DD'),
					moment().endOf('month').format('YYYY-MM-DD')
				]
			},
			rawEvents: []
		}
	},
	methods:{
		fetchEvents() {
			let daterange = this.filters.daterange

			if (!daterange) {
				this.$notify.error({
		          	title: 'Invalid Data',
		          	message: 'You need to select daterange first.'
		        })

				return
			}

			let postData = {
				daterange
			}

			this.retreiving = true
			this.$API.Event.fetchEvents(postData)
			.then(res => {
				if (res.data.success) {
					this.rawEvents = res.data.data.map(ev => {
						ev.included_days = JSON.parse(ev.included_days)
						
						return ev
					})
				}
			})
			.catch(err => {
				this.$notify.error({
		          	title: 'Fetch Error',
		          	message: 'Failed to fetch events. Please report this to your administrator.'
		        })
			})
			.finally(_ => {
				this.retreiving = false
			})
		}
	}
}