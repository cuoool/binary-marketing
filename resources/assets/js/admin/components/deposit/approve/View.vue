<template>
	<md-card class="content-form">
		<md-card-header>
      <div class="md-title">Deposit History</div>
    </md-card-header>
		<md-card-content class="content-body">
      <div class="col-md-12 sec-block">
      	<dl class="dl-horizontal">
      		<dt>Username</dt>
      		<dd>{{ data.owner.username }}</dd>
    		</dl>
        <dl class="dl-horizontal">
          <dt>Email</dt>
          <dd>{{ data.owner.email }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Deposit Amount</dt>
          <dd>{{ data.amount | currency }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Status</dt>
          <dd>
            <span class="label label-sm label-warning" v-if="data.status == 0">Pending</span>
            <span class="label label-sm label-success" v-if="data.status == 1">Approved</span>
            <span class="label label-sm label-danger" v-if="data.status == 2">Expired</span>
          </dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Plan</dt>
          <dd>
            <span :class="'label label-sm label-' + data.plan.name.toLowerCase()">{{ data.plan.name }}</span>
          </dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Bitcoin Address</dt>
          <dd>{{ data.owner.bitcoin_account }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Issue Date</dt>
          <dd>{{ data.issue_date }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Expire Date</dt>
          <dd>{{ data.expire_date }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Deposited Date</dt>
          <dd>{{ data.created_at }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Bankslip</dt>
          <dd><img :src="data.bankslip" style="max-width: 800px;"></dd>
        </dl>
      </div>
    </md-card-content>
    <div v-if="data.crypto_payment != null">
      <md-card-header>
        <div class="md-title">Payment History</div>
      </md-card-header>
      <md-card-content class="content-body">
        <div class="col-md-12 sec-block">
          <dl class="dl-horizontal">
            <dt>Box ID</dt>
            <dd>{{ data.crypto_payment.boxID }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Order ID</dt>
            <dd>{{ data.crypto_payment.orderID }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Bitcoin amount</dt>
            <dd>{{ data.crypto_payment.amount }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>USD amount</dt>
            <dd>$ {{ data.crypto_payment.amountUSD }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Unrecognised</dt>
            <dd>{{ data.crypto_payment.unrecognised | isActive }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Tx ID</dt>
            <dd>{{ data.crypto_payment.txID }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Tx Date</dt>
            <dd>{{ data.crypto_payment.txDate }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Tx Confirmed</dt>
            <dd>{{ data.crypto_payment.txConfirmed | isActive }}</dd>
          </dl>
        </div>
      </md-card-content>
    </div> 
    <md-card-actions>
	    <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
	  </md-card-actions>
  </md-card>
</template>

<script>
import { mapActions } from 'vuex'
import _mixin from '../../../core/mixins/table'

export default{

	mixins: [_mixin],

	props: ['data'],

	data(){
		return {
		}
	},

	methods:{

		...mapActions({
  		saveEmail: 'customer/editEmail',
  		saveBitCoinAddress: 'customer/editBitCoinAddress'
  	})
	}
}
</script>


<style lang="scss" scoped>
.sec-block{
	padding: 0;
}
</style>