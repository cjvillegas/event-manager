<template>
	<div class="calendar-basic-component">
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<h3 class="card-title-custom">Calendar Basic</h3>
			</div>

			<section>
				<div class="row">
					<!-- Event Form -->
					<div 
						class="col-lg-3 col-md-4 col-sm-5">
						<h2>Add Event</h2>
						<event-form
							:is-modal="false">
						</event-form>
					</div>
					<!-- End of Event Form -->

					<!-- Calendar Section -->
					<div 
						class="col-lg-9 col-md-8 col-sm-7"
						v-loading="retreiving">
						<div class="d-flex">
							<h2>Calendar</h2>
							<el-date-picker
								class="ml-3"
								start-placeholder="Start date"
      							end-placeholder="End date"
								value-format="yyyy-MM-dd"
								v-model="filters.daterange"
								clearable
								type="daterange">
							</el-date-picker>

							<el-button
								@click="fetchEvents"
								style="height: 32px;"
								class="ml-3"
								size="small"
								type="primary">
								Load
							</el-button>
						</div>
						<div 
							class="calendar-container"
							v-for="(month, name) in computedCalendar"
							:key="name">
							<div class="month-header">{{ name }}</div>
							<div>
								<el-table
									:data="month"
									size="small"
									:show-header="false">
									<el-table-column width="200">
										<template slot-scope="scope">
											{{ scope.row.day }}
										</template>
									</el-table-column>
									<el-table-column>
										<template slot-scope="scope">
											<span class="ml-5">
												{{ scope.row.events }}
											</span>
										</template>
									</el-table-column>
								</el-table>
							</div>
						</div>
					</div>
					<!-- End of Calendar Section -->
				</div>
				
			</section>
		</el-card>
	</div>
</template>

<script>
	import moment from 'moment'
	import cloneDeep from 'lodash/cloneDeep'
	
	import calendar from '../mixins/calendar'
	export default {
		name: 'CalendarBasic',
		mixins: [calendar],
		data() {
			return {}
		},
		created() {
			this.fetchEvents()
		},
		computed: {
			computedCalendar() {
				let start = cloneDeep(this.filters.daterange ? this.filters.daterange[0] : null)
				let end = cloneDeep(this.filters.daterange ? this.filters.daterange[1] : null)
				let defStart = moment().startOf('month').format('YYYY-MM-DD')
				let defEnd = moment().endOf('month').format('YYYY-MM-DD')
				let actualStart = moment(start ? start : defStart)
				let actualEnd = moment(end ? end : defEnd)
				let months = {}
				let events = cloneDeep(this.rawEvents)

				while (actualStart <= actualEnd) {
					let monthYear = actualStart.format('MMM YYYY')
					let day = actualStart.format('DD ddd')
					let dayName = actualStart.format('ddd').toLowerCase()

					if (!months[monthYear]) {
						months[monthYear] = []
					}

					let event = events.filter(ev => moment(actualStart.format('YYYY-MM-DD')).isBetween(ev.event_start, ev.event_end, null, '[]') 
						&& ev.included_days.includes(dayName))

					let dayObject = {
						day: day,
						events: event.reduce((acc, cur) => acc += acc ? `, ${cur.event_name}` : cur.event_name, '')
					}

					months[monthYear].push(dayObject)

					actualStart = moment(moment(actualStart).add(1, 'days').format('YYYY-MM-DD'))
				}


				return months
			}
		}
	}
</script>

<style lang="scss">
	.calendar-basic-component {

		.month-header {
			font-size: 22px;
			font-weight: 600;
		}
	}
</style>