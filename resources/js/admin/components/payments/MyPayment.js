import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import $ from "jquery";
import { Redirect } from 'react-router';
import { Helmet } from 'react-helmet';
import Chart from './../Chart';

class MyPayment extends Component {

    constructor(props){
        super(props);
        this.state = {
            payments: [],
            total: '',
            chartData:[]
        }
        this.fetchPaymentLogs = this.fetchPaymentLogs.bind(this);
    }

    

    componentWillMount(){
      // this.getchartData(); // this should be this.getChartData();
       this.getChartData();
     }

     getChartData(){
      // Ajax calls here
      axios.get('/api/payments/my-payment-chart-data')
            .then((response) => {
                
                this.setState({chartData: response.data.data} );
                const chart_data = response.data.data
                const title = []
                const value = []
                
                chart_data.forEach(record => {
                  title.push(record.key)
                  value.push(record.value)
                })
                console.log(title, 'title')
                console.log(value, 'value')
                this.setState({
                  chartData:{
                    labels: title,
                    datasets:[
                      {
                        label:'',
                        data:value,
                        backgroundColor:[
                          'rgba(255, 99, 132, 0.6)',
                          'rgba(54, 162, 235, 0.6)',
                          'rgba(255, 206, 86, 0.6)',
                          'rgba(75, 192, 192, 0.6)',
                          'rgba(153, 102, 255, 0.6)',
                          'rgba(255, 159, 64, 0.6)',
                          'rgba(255, 99, 132, 0.6)'
                        ]
                      }
                    ]
                  }
                });
                
            })
            .catch((error) => {
                console.log(error);
            });

           
     
    }

    componentDidMount() {
        this.fetchPaymentLogs();
     }
 
     fetchPaymentLogs(){
        axios.get('/api/payments/my-payments')
            .then((response) => {
                console.log("response", response);
                this.setState({payments: response.data.payments} );
                this.setState({total: response.data.total} );
            })
            .catch((error) => {
                console.log(error);
            });
    }

    kFormatter = (num) => {
      return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K' : Math.sign(num)*Math.abs(num)
  }
    
     render(){
         return (
          <>
          <Helmet> <title>Minibus - My Payments</title> </Helmet>
          
            <section id="configuration" className="search view-cause view operator-list q-state payment">
                <div className="row">
              <div className="col-12">
                <div className="card rounded pad-20">
                  <div className="card-content collapse show">
                    <div className="card-body table-responsive card-dashboard">
                      <div className="row">
                        <div className="col-md-6 col-12">
                          <h1 className="pull-left">My payment Log</h1>
                        </div>
                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/payments">payments</Link></li>
                                                <li className="breadcrumb-item active"> My payments</li>
                                            </ol>
                                        </div>
                      </div>
              
                <div className="row">
                  <div className="col-12">
                    <div className="card">
                      <div className="card-header">
                          <div className="row">
                              <div className=" col-12 text-center">
                                  
                              <h4 className="card-title">Total £{ this.kFormatter(this.state.total)}</h4>
                              </div>
                          </div>
                        
                          <Chart chartData={this.state.chartData} location="Massachusetts" legendPosition="bottom"/>
                      </div>
                      <div className="card-content collapse show">
                        <div className="card-body"> 
                            {/* <div className="row d-flex align-items-center">
                            <div className="col-lg-2 col-12 text-center">
                              <h5>earnings</h5>
                                </div>
                            <div className="col-lg-10 col-12">
                          <div id="basic-column" className="height-400 echart-container"></div>
                        </div>
                                </div> */}
                            </div>
                      </div>
                        {/* <div className="row">
                            
                            <div className="col-12 text-center">
                            <h5>Month</h5>
                            </div>
                        </div> */}
                    </div>
                  </div>
                </div>
                        
                        
                         {/* <div className="dates">
                            <div className="row">
                              <div className="col-xl-3 offset-xl-6 offset-lg-5 offset-md-4 col-lg-3 col-md-4 col-12 ">
                                <p>from</p>
                                <input id="datepicker-1" placehodler="Form" className="form-control"/>
                              </div>
                              <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                <p>To </p>
                                <input id="datepicker-2" placehodler="to"  className="form-control"/>
                              </div>
                            </div>
                          </div> */}
                        
                            <div className="maain-tabble">
                            { this.state.payments.length ?
                                <DataTable
                                    data={this.state.payments}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "date" },
                                        { title: "User Type", data: "type" },
                                        { title: "Name", data: "name" },
                                        { title: "Action Performed", data: "action" },
                                        { title: "Amount Received", "render": function ( data, type, row ) {
                                              return '£'+row.amount;
                                        }},
                                        { title: "Amount Paid", "render": function ( data, type, row ) {
                                          return '£'+row.paid;
                                    }}
                                        
                                    ]}
                                    class="table table-striped table-bordered"
                                /> : <p>No Record Found!</p>
                            }
                          </div> 
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </section>
 </>
             );
     }
}

export default withRouter(MyPayment);
