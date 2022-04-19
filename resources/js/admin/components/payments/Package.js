import React, {Component, Fragment} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import { Helmet } from 'react-helmet'

class Package extends Component {

    constructor(props){
        super(props);
        this.state = {
            packages: [],
            payments: [],
        }
        this.fetchPackages = this.fetchPackages.bind(this);
        this.fetchPaymentLogs = this.fetchPaymentLogs.bind(this);
    }



    componentDidMount() {
        this.fetchPackages();
        this.fetchPaymentLogs();
     }
 
     fetchPackages(){
        axios.get('/api/payments/packages')
            .then((response) => {
                console.log("response", response);
                this.setState({packages: response.data.packages} );
            })
            .catch((error) => {
                console.log(error);
            });
    }

    fetchPaymentLogs(){
        axios.get('/api/payments/operator-payment-logs')
            .then((response) => {
                console.log("response", response);
                this.setState({payments: response.data.payments} );
            })
            .catch((error) => {
                console.log(error);
            });
    }


   
    render(){
        return (
            <>
            <Helmet> <title>Minibus - Payments</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state package-log">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row">
                            <div className="col-md-6 col-12">
                            <h1 className="pull-left">package log</h1>
                            </div>
                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/payments">payments</Link></li>
                                                <li className="breadcrumb-item active"> Package Log</li>
                                            </ol>
                                        </div>
                        </div>
                        <div className="row">
                            <div className="col-xl-5 col-lg-8 col-12">
                            <div className="package-log-box">
                                <h2>Quotation Packages </h2>
                                <h3>1 Quotation is equal to £1</h3>
                                {
                                    this.state.packages.map((pkg, i) => {
                                    return (
                                    
                                     <Fragment><p>Package {pkg.id}: {pkg.title} </p></Fragment>
                                    

                                    ) 
                                    })
                                }
                                
                            </div>
                            </div>
                        </div>
                        <div className="maain-tabble">
                        { this.state.payments.length ?
                                <DataTable
                                    data={this.state.payments}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "date" },
                                        { title: "Operator Name", data: "operator_name" },
                                        { title: "Package Selected", data: "package" },
                                        { title: "Amount Paid", "render": function ( data, type, row ) {
                                            return '£'+row.amount;
                                        }},
                                        
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

export default withRouter(Package);
