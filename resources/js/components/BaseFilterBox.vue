<template>
	<el-popover
		ref="filterBox"
		:placement="placement"
	    :width="width"
	    trigger="click"
	    :popper-class="customClassName +' filter-box-class'">
		
    	<header class="filter-box-header">
	    	<span>{{ customTitle }}</span>
	    	<el-button 
	    		class="pull-right filter-close-button"
	    		type="text" 
	    		icon="el-icon-close"
	    		@click="closeFilterBox">
	    	</el-button>
	    </header>

	    <section class="filter-box-body">
	   		<slot name="body" ></slot>
	    </section>

	    <slot v-if="hasRefSlot" name="reference" slot="reference"></slot>

	    <el-button 
	    	v-else
	    	class="btn btn-outline-gray" 
	    	slot="reference" 
	    	title="Filter">
	        <svg 
	        	width="1em" 
	        	height="1em" 
	        	viewBox="0 0 16 16" 
	        	class="bi bi-funnel" 
	        	fill="currentColor" 
	        	xmlns="http://www.w3.org/2000/svg">
	            <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
	          </svg>
      	</el-button>
  </el-popover>
</template>

<script>
	export default {
		name: 'BaseFilterBox',
		props: {
			customTitle: {
				type: String,
				required: false,
				default: 'Filters'
			},
			customClassName: { // Custome Popover class
				type: String,
				required: false,
				default: ''
			},
			width: {
				type: [String, Number],
				required: false,
				default: 300
			},
			placement: {
				type: String,
				default: 'bottom'
			},
		},
		data() {
			return {}
		},
		methods: {
			closeFilterBox() {
				this.$refs.filterBox.showPopper = false
			},
		},
		computed: {
			hasRefSlot () {
				return !!this.$slots['reference']
			},
		}
	}
</script>

<style lang="scss">
	.filter-box-class {
		padding: 10px;

	    .filter-box-header {
	      	font-weight: bold;
	      	font-size: 15px !important;
	      	display: flex;
    		align-items: baseline;
    		border-bottom: 1px solid #B5B6BA;
		    margin-bottom: 20px;
		    padding-bottom: 10px;
	    }

	    .filter-close-button {
    	    position: absolute;
		    right: 8px;
		    top: 0px;
		    color: #000;
	    }
	}
</style>