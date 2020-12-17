<template>	
	<div>
		<el-form
			v-loading="loading"
			label-position="top"
			:rules="rules"
			:model="eventForm"
			ref="eventForm"
			class="event-management-el-form">
			<el-form-item
				label="Event Name"
				prop="event_name">
				<el-input
					class="full-width"
					placeholder="Enter event name"
					v-model="eventForm.event_name"
					clearable>
				</el-input>
			</el-form-item>

			<div class="row">
				<div class="col-md-6">
					<el-form-item
						class="full-width"
						label="From"
						prop="event_start">
						<el-date-picker
							placeholder="Pick start date"
							value-format="yyyy-MM-dd"
							class="full-width"
							v-model="eventForm.event_start"
							clearable
							:picker-options="startPickerOption"
							type="date">
						</el-date-picker>
					</el-form-item>
				</div>
				<div class="col-md-6">
					<el-form-item
						label="To"
						prop="event_end">
						<el-date-picker
							placeholder="Pick end date"
							value-format="yyyy-MM-dd"
							class="full-width"
							v-model="eventForm.event_end"
							:picker-options="endPickerOption"
							clearable
							type="date">
						</el-date-picker>
					</el-form-item>
				</div>
			</div>

			<el-checkbox 
				:indeterminate="isIndeterminate" 
				v-model="checkAll" 
				@change="handleCheckAll">
				Check all
			</el-checkbox>

			<el-form-item
				prop="days">
				<el-checkbox-group 
					v-model="eventForm.included_days">
					<el-checkbox 
						v-for="day in days" 
						:label="day.value" 
						:key="day.value">
						{{ day.label }}
					</el-checkbox>
				</el-checkbox-group>
			</el-form-item>
		</el-form>
		
		<el-button
			v-if="!isModal"
			type="primary"
			class="full-width"
			@click="saveEvent">
			Save
		</el-button>
	</div>		
</template>

<script>
	export default {
		name: 'EventForm',
		props: {
			isModal: {}
		},
		data() {
			let days = [
				{label: 'Mon', value: 'mon'},
				{label: 'Tue', value: 'tue'},
				{label: 'Wed', value: 'wed'},
				{label: 'Thu', value: 'thu'},
				{label: 'Fri', value: 'fri'},
				{label: 'Sat', value: 'sat'},
				{label: 'Sun', value: 'sun'},
			]

			return {
				loading: false,
				checkAll: false,
				eventForm: {
					event_name: null,
					event_start: null,
					event_end: null,
					included_days: []
				},
				days: days,
				rules: {
					event_name: {required: true, message: 'Event name is required', trigger: 'blur'},
					event_start: {required: true, message: 'Event name is required', trigger: 'blur'},
					event_end: {required: true, message: 'Event name is required', trigger: 'blur'},
				},
				startPickerOption: {
					disabledDate: date => {
						return moment(date).diff(this.eventForm.event_end, 'days') > 0
					}
				},
				endPickerOption: {
					disabledDate: date => {
						return moment(date).diff(this.eventForm.event_start, 'days') < 0
					}
				},
			}
		},
		created() {
			this.$ED.listen('EVENT_MODAL_CLOSED', _ => {
				this.resetForm()
			})

			this.$ED.listen('FIRE_EVENT_SAVED', _ => {
				this.saveEvent()
			})
		},
		methods: {
			saveEvent() {
				this.$refs.eventForm.validate(valid => {
					if (valid) {
						if (!this.eventForm.included_days.length) {
							this.$notify.error({
					          	title: 'Invalid Data',
					          	message: 'You need to select days where to apply the events.'
					        })
							return 
						}

						this.loading = true

						this.$API.Event.saveEvent(this.eventForm)
						.then(res => {
							if (res.data.success) {
								this.$notify.success({
						          	title: 'Successful',
						          	message: 'You have successfully saved an event.'
						        })

						        this.$ED.fire('EVENT_SAVED_SUCCESSFULLY')

						        this.resetForm()
							}
						})
						.catch(err => {
							console.log(err)
						})
						.finally(_ => {
							this.loading = false
						})
					} else return false
				})
			},
			resetForm() {
				this.eventForm = {
					event_name: null,
					event_start: null,
					event_end: null,
					included_days: []
				}

				this.checkAll = false;

				setTimeout(_ => {
					if (this.$refs.eventForm) this.$refs.eventForm.clearValidate()
				}, 200)
			},
			handleCheckAll(val) {
				this.eventForm.included_days = val ? this.days.map(d => d.value) : []
			},
		},
		computed: {
			isIndeterminate() {
				let isIndeterminate = false
				let daysLength = this.days.length
				let sDaysLength = this.eventForm.included_days.length

				if (sDaysLength === daysLength) this.checkAll = true
				if (sDaysLength && sDaysLength < daysLength) isIndeterminate = true

				return isIndeterminate
			},
		},
		destroyed() {
			this.$ED.destroy([
				'EVENT_MODAL_CLOSED',
				'FIRE_EVENT_SAVED'
			])
		}
	}
</script>

<style lang="scss">
	
</style>