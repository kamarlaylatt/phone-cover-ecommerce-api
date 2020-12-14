<template>
  <div>

    <b-container fluid class="row justify-content-md-center mb-2">
      <b-card bg-variant="light">
        <b-form inline>
          <b-form-select class="mr-2" v-model="order_type" :options="options"></b-form-select>
          <b-form-datepicker
            v-model="start_date"
            id="datepicker-buttons"
            today-button
            reset-button
            close-button
            locale="en"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Start Date"
          ></b-form-datepicker>
          <span class="mr-2 small">to</span>
          <b-form-datepicker
            v-model="end_date"
            id="datepicker-buttons2"
            today-button
            reset-button
            close-button
            locale="en"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="End Date"
          ></b-form-datepicker>
          <VueLoadingButton 
          @click.native="find"
          class="btn btn-primary"
          :loading="isLoading"
          ><small>Find</small>
          </VueLoadingButton>
        </b-form>
      </b-card>
    </b-container>

    
    <b-container fluid class="filter-font mb-2">
      <!-- User Interface controls -->
      <b-card bg-variant="light">
        <b-row>
          <b-col lg="6" class="my-1">
            <b-form-group
              label="Sort"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="md"
              label-for="sortBySelect"
              class="mb-0"
            >
              <b-input-group size="md">
                <b-form-select v-model="sortBy" id="sortBySelect" :options="sortOptions" class="w-75">
                  <template v-slot:first>
                    <option value="">-- none --</option>
                  </template>
                </b-form-select>
                <b-form-select v-model="sortDesc" size="md" :disabled="!sortBy" class="w-25">
                  <option :value="false">Asc</option>
                  <option :value="true">Desc</option>
                </b-form-select>
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col lg="6" class="my-1">
          </b-col>

          <!-- <b-col lg="6" class="my-1">
            <b-form-group
              label="Initial sort"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="md"
              label-for="initialSortSelect"
              class="mb-0"
            >
              <b-form-select
                v-model="sortDirection"
                id="initialSortSelect"
                size="md"
                :options="['asc', 'desc', 'last']"
              ></b-form-select>
            </b-form-group>
          </b-col> -->

          <b-col lg="6" class="my-1">
            <b-form-group
              label="Filter"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="md"
              label-for="filterInput"
              class="mb-0"
            >
              <b-input-group size="md">
                <b-form-input
                  v-model="filter"
                  type="search"
                  id="filterInput"
                  placeholder="Type to Search"
                ></b-form-input>
                <b-input-group-append>
                  <b-button :disabled="!filter" variant="primary" @click="filter = ''">Clear</b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col lg="6" class="my-1">
            <b-form-group
              label="Filter On"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="md"
              description="Leave all unchecked to filter on all data"
              class="mb-0">
              <b-form-checkbox-group v-model="filterOn" class="mt-1">
                <b-form-checkbox value="order_no">Order No</b-form-checkbox>
                <b-form-checkbox value="customer_name">Customer Name</b-form-checkbox>
                <b-form-checkbox value="order_status">Order Status</b-form-checkbox>
                <b-form-checkbox value="phone">Phone</b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>
          </b-col>

          <b-col sm="5" md="6" class="my-1">
            <b-form-group
              label="Per page"
              label-cols-sm="6"
              label-cols-md="4"
              label-cols-lg="3"
              label-align-sm="right"
              label-size="md"
              label-for="perPageSelect"
              class="mb-0"
            >
              <b-form-select
                v-model="perPage"
                id="perPageSelect"
                size="md"
                :options="pageOptions"
              ></b-form-select>
            </b-form-group>
          </b-col>

          <b-col sm="7" md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              align="fill"
              size="md"
              class="my-0"
            ></b-pagination>
          </b-col>
        </b-row>
      </b-card>

      <!-- Main table element -->
      <b-table
        show-empty
        small
        stacked="md"
        striped 
        responsive="md"
        :items="items"
        :fields="fields"
        :current-page="currentPage"
        :per-page="perPage"
        :filter="filter"
        :filter-included-fields="filterOn"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :sort-direction="sortDirection"
        :busy="isLoading"
        @filtered="onFiltered"
      >
        <template v-slot:table-busy>
          <div class="text-center text-primary my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>Loading...</strong>
          </div>
        </template>
        <template v-slot:cell(show_details)="row">
          <button size="md" @click="row.toggleDetails" class="mr-2 primary">
            {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
          </button>

          <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
          <!-- <b-form-checkbox v-model="row.detailsShowing" @change="row.toggleDetails">
            Details via check
          </b-form-checkbox> -->
        </template>

        <template v-slot:cell(no)="data">
          {{ ((currentPage*perPage)+data.index + 1)-perPage }}
        </template>

        <template v-slot:cell(order_status)="data">
          <h5><b-badge :style="{backgroundColor: data.item.order_status_color}">{{ data.item.order_status }}</b-badge></h5>
        </template>

        <template v-slot:row-details="row">
          <b-card>
            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Order Date:</b></b-col>
              <b-col>{{ row.item.date }}</b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Order No:</b></b-col>
              <b-col>{{ row.item.order_no }}</b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Order Status:</b></b-col>
              <b-col><h5><span class="badge badge-pill text-white" :style="{backgroundColor: row.item.order_status_color}">{{ row.item.order_status }}</span></h5></b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Customer Name:</b></b-col>
              <b-col>{{ row.item.customer_name }}</b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Phone:</b></b-col>
              <b-col>{{ row.item.phone }}</b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Address:</b></b-col>
              <b-col>{{ row.item.address }}</b-col>
            </b-row>

            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Total Item:</b></b-col>
              <b-col>{{ row.item.total_item }}</b-col>
            </b-row>

            <b-row class="mb-2" v-if="row.item.total_price != null">
              <b-col sm="3" class="text-sm-right"><b>Total Amount:</b></b-col>
              <b-col>{{ row.item.total_price }}</b-col>
            </b-row>           

            <!-- <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button> -->
            <button size="md" @click="showMore(row.item.id,row.item.order_type)">Show More >></button>
          </b-card>
        </template>
      </b-table>
    </b-container>
  </div>
</template>

<script>
import VueLoadingButton from 'vue-loading-button';
  export default {
    props: ['base_url'],
    data() {
      return {
        isLoading: false,
        order_type: 1,
        start_date: new Date,
        end_date: new Date,
        options: [
          { value: '1', text: 'Product Order' },
          { value: '2', text: 'DIY Order' },
          { value: '3', text: 'Help me Design Order'},

        ], 
        items: '',
        // items: [
        //   {no:1, order_no: 123456, customer_name: 'kyaw kyaw', phone: '09263683288', order_status: true}
        // ],
        fields: [
          { key: 'no', label: 'No', sortable: true},
          { key: 'order_no', label: 'Order No', sortable: true, class: 'text-center' },
          { key: 'customer_name', label: 'Customer Name' },
          { key: 'phone', label: 'Phone', sortable: true },
          {
            key: 'order_status',
            label: 'Order Status',
            // sortable: true,
          },
          {
            key: 'show_details',
            label: 'Show Detail'
          }
        ],
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [5, 10, 15, 20, 30, 50],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        infoModal: {
          id: 'info-modal',
          title: '',
          content: ''
        }
      }
    },
    components: {
			VueLoadingButton
		},
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    mounted() {
      // Set the initial number of items
      this.totalRows = this.items.length
    },
    methods: {
      info(item, index, button) {
        this.infoModal.title = `Row index: ${index}`
        this.infoModal.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },

      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
      },

      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },

      showMore(id,order_type){
        if(order_type == 1)
        {
          window.open(this.base_url+"/admin/orders/"+id+"/show", "_blank");   
        }else{
          window.open(this.base_url+"/admin/intensions/"+id+"/show", "_blank");   
        }
      },

      find(){
        this.isLoading = true;
        axios.get('/admin/order-filter/filtering', {
          params: {
            order_type: this.order_type,
            start_date: this.start_date,
            end_date: this.end_date
          }
        }).then((response)=>{
            console.log(response.data)
            if(response.data.status == 1)
            {
              this.items = response.data.data
              this.totalRows = response.data.data.length
              this.currentPage = 1
              this.isLoading = false;
            }
            
        }).catch(function (error){
          console.log(error.response)
          if(error.response)
          {
            alert(error.response.data.message)
          }
        })
      }
    }
  }
</script>
<style scoped>
    .filter-font{
        font-size: 16px;
    }
</style>