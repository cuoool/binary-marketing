<template>
	<div>
	    <component :is="current_view" :data="data"
	    		@show-create="current_view = '_Create'"	 
	    		@show-view="showView"     		
	    		@show-edit="showEdit"
	    		@close-form="current_view = '_Table'">
	  	</component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins'
import _Table from './Table.vue'
import _Edit from './Edit.vue'
import _Create from './Create.vue'

export default{

	mixins: [_mixin],

	components: {
		_Table,
		_Edit,
		_Create
	},

	data(){
		return {
			current_view : '_Table',
			data: null
		}
	},

	methods:{
		...mapActions({
	  		clearStore: 'faq/clearStore'
		})
	},

	beforeRouteLeave (to, from, next){
    	this.clearStore();
    	next();
	}
}
</script>