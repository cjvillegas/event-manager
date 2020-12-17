<template>
	<div class="calendar-advance-component">
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<h3 class="card-title-custom">Calendar Modified</h3>
			</div>

			<section v-loading="retreiving">
				<section class="text-right">
					<base-filter-box 
						width="360"
						class="base-filter-box">
						<el-form
							label-position="top"
							slot="body"
							class="filter-el-form">
							<el-date-picker
								class="full-width"
								start-placeholder="Start date"
	  							end-placeholder="End date"
								value-format="yyyy-MM-dd"
								v-model="filters.daterange"
								clearable
								type="daterange">
							</el-date-picker>

							<el-button
								type="primary"
				  				class="full-width mt-3"
							  	@click="fetchEvents">
				                Apply
			              	</el-button> 
						</el-form>
					</base-filter-box>

					<el-button
						type="primary"
						@click="showForm = true">
						Add Event
					</el-button>	
				</section>

				<el-calendar 
					v-model="calendar"
					ref="calendar">
					<template
						slot="dateCell"
						slot-scope="{date, data}">
						<p :class="data.isSelected ? 'is-selected' : ''">
							{{ data.day.split('-').slice(1).join('-') }} {{ getEvent(data, date) ? '✔️' : ''}}

							<div class="text-center">
								{{ getEvent(data, date) }}
							</div>
						</p>
					</template>
				</el-calendar>
			</section>
			
		</el-card>

		<el-dialog
			:visible.sync="showForm"
			@close="closeEventForm"
			title="Add Event"
			width="40%">
			<event-form
				:is-modal="true">
			</event-form>

			<span slot="footer" class="dialog-footer">
			    <el-button 
			    	@click="closeEventForm">
			    	Cancel
			    </el-button>
			    <el-button 
			    	type="primary"
			    	@click="saveEvent">
			    	Save
			    </el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
	import calendar from '../mixins/calendar'
	export default {
		name: 'CalendarModified',
		mixins: [calendar],
		data() {
			return {
				showForm: false,
				calendar: new Date(),
			}
		},
		created() {
			this.fetchEvents()

			this.$ED.listen('EVENT_SAVED_SUCCESSFULLY', _ => {
				this.showForm = false
				this.fetchEvents()
			})
		},
		methods: {
			getEvent(data, date) {
				let event = this.rawEvents.filter(ev => {
					let day = moment(data.day)
					if (day.isBetween(ev.event_start, ev.event_end, null, '[]') && ev.included_days.includes(day.format('ddd').toLowerCase())) {
						return true
					}

					return false
				})

				if (event.length) {
					data.isSelected = true
				}

				return event.reduce((acc, cur) => acc += acc ? `, ${cur.event_name}` : cur.event_name, '')
			},
			closeEventForm() {
				this.showForm = false

				this.$ED.fire('EVENT_MODAL_CLOSED')
			},
			saveEvent() {
				this.$ED.fire('FIRE_EVENT_SAVED')
			}
		},
		watch: {
			calendar(val, oldVal) {
				if (moment(val).format('YYYY-MM') !== moment(oldVal).format('YYYY-MM')) {
					this.filters.daterange = [
						moment(val).startOf('month').format('YYYY-MM-DD'),
						moment(val).endOf('month').format('YYYY-MM-DD')
					]

					this.fetchEvents()
				}
			}
		},
		destroyed() {
			this.$ED.destroy([
				'EVENT_SAVED_SUCCESSFULLY'
			])
		}
	}
</script>

<style lang="scss">
	.calendar-advance-component {
		
	}
</style>