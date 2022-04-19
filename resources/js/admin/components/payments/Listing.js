import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams, NavLink } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import toastr from 'toastr';
import $ from "jquery";
import { Redirect } from 'react-router';
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import dateFormat from 'dateformat';
import { Helmet } from 'react-helmet'

class Listing extends Component {

    constructor(props){
        super(props);
        this.state = {
            users: [],
            operators: [],
            path: '',
            booking_id:''
        }
         this.fetchPayments = this.fetchPayments.bind(this);
         this.handleClick = this.handleClick.bind(this);
         this.handleStartDateChange = this.handleStartDateChange.bind(this);
         this.handleEndDateChange = this.handleEndDateChange.bind(this);
         this.handleSubmit = this.handleSubmit.bind(this);
         this.handleSearch = this.handleSearch.bind(this);
         this.toggleModal = this.toggleModal.bind(this);
        // this.handleRefundUser = this.handleRefundUser.bind(this);
         this.toggleModalOperator = this.toggleModalOperator.bind(this);
       //  this.handlePayOperator = this.handlePayOperator.bind(this);
         this.clearAll = this.clearAll.bind(this);
    }



    componentDidMount() {
        this.fetchPayments();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'view'){
            this.props.history.push("/payments/view/"+id);
        }
    }

    handleRedirect = (path) => {
      this.setState({path: path});
    }

     fetchPayments(){
        var url = 'api/payments';
         axios.get(url)
            .then((response) => {
              
                this.setState({ users: response.data.users, operators: response.data.operators}, 
                    () => { console.log("state",this.state);
                });
               
            })
            .catch((error) => {
                console.log(error);
            });
    }

    reloadTableData(names) {
        const table = $('.data-table-wrapper')
            .find('table')
            .DataTable();
        table.clear();
        table.rows.add(names);
        table.draw();
    }

    handleStartDateChange (date){
        this.setState({
          from: date
        });
      };

      handleEndDateChange (date){
        this.setState({
          to: date
        });
      };

      handleSubmit(event){
        event.preventDefault();
        console.log(dateFormat(this.state.from, "yyyy-mm-dd"));
        console.log(this.state.to);
        const data = new FormData(event.target);
        axios.get(`api/payments?from=${dateFormat(this.state.from, "yyyy-mm-dd")}&to=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
            .then((response) => {
                this.setState({ users: response.data.users}, 
                    () => { 
                        // console.log("state",this.state);
                });
                // console.log('count',this.state.users.length);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    handleSearch(event){
        event.preventDefault();
        const data = new FormData(event.target);
        axios.get(`api/payments?start=${dateFormat(this.state.from, "yyyy-mm-dd")}&end=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
            .then((response) => {
                this.setState({ operators: response.data.operators}, 
                    () => {
                     // console.log("state",this.state);
                });
                // console.log('count',this.state.operators.length);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    toggleModal(data, e) {
        e.preventDefault();
         console.log('data', data);
      
        this.setState({ booking_id: data.booking_id },() => {
        console.log(this.state.booking_id, 'booking_id')});
        axios.post('api/quotations/refund',data)
        .then((response) => {
            toastr.success(response.data.message, 'Success');
            setTimeout(()=> {
                window.location = window.base_url +'/admin/payments';
            }, 1000);
        })
        .catch((error) => {
            console.log(error);
        });
     
    }

    // handleRefundUser(event){
    //     event.preventDefault();
    //     const data = new FormData(event.target);
    //     axios.post('api/quotations/refund',data)
    //         .then((response) => {
    //             toastr.success(response.data.message, 'Success');
    //             setTimeout(()=> {
    //               //  this.props.history.push('/payments');
    //                 window.location ='/admin/payments';
    //             }, 700);
    //         })
    //         .catch((error) => {
    //             console.log(error);
    //         });
    // }

    toggleModalOperator(data) {
      
        axios.post('api/quotations/payOperator',data)
        .then((response) => {
            toastr.success(response.data.message, 'Success');
            setTimeout(()=> {
              //  this.props.history.push('/payments');
                window.location = window.base_url +'/admin/payments';
            }, 1000);
        })
        .catch((error) => {
            console.log(error);
        });
    }

    handlePayOperator(event){
        event.preventDefault();
        const data = new FormData(event.target);
        axios.post('api/quotations/payOperator',data)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                  //  this.props.history.push('/payments');
                    window.location =window.base_url +'/admin/payments';
                }, 700);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    clearAll(){
        console.log('clear');
        this.setState({
            from: '',
            to: ''
          });
    }

    kFormatter = (num) => {
        return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K' : Math.sign(num)*Math.abs(num)
    }

    render(){
        // console.log('count',this.state.users.length);
       
      if (this.state.path) {
            console.log("path",this.state.path)
        return <Redirect push to={this.state.path} />;
      }
    
    
        return (
            <div>
            <Helmet> <title>Minibus - Payments</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state payment">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                        <div className="card-content collapse show">
                            <div className="card-body table-responsive card-dashboard">
                            <div className="row">
                                <div className="col-md-6 col-12">
                                <h1 className="pull-left">payments</h1>
                                </div>
                                {/* <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                    <div className="breadcrumb-wrapper col-12">
                                    <ol className="breadcrumb">
                                        <li className="breadcrumb-item"><Link to="payments">Payments</Link></li>
                                        <li className="breadcrumb-item active">All Payments</li>
                                    </ol>
                                    </div>
                                </div> */}
                            </div>
                            
                            <ul className="nav nav-tabs nav-underline no-hover-bg">
                                <li className="nav-item"> <a className="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" aria-expanded="true">user</a> </li>
                                <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab36" data-toggle="tab" aria-controls="tab36" href="#tab36" aria-expanded="false">operator</a> </li>
                            </ul>
                            <div className="tab-content ">
                                <div role="tabpanel" className="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
                                <div className="top">
                                    <div className="row">
                                    <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 "> <a style={{color: '#fff'}} onClick={ () => this.handleRedirect('/payments/package')} type="button" className="pur">Package Log</a> </div>
                                    </div>
                                    <div className="row">
                                    <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 "> <a style={{color: '#fff'}} onClick={ () => this.handleRedirect('/payments/mypayments')} type="button" className="yel">My Payment Log</a> </div>
                                    </div>
                                </div>
                                <div className="dates">
                                <form ref={c => { this.form = c }} onSubmit={this.handleSubmit}>
                                    <div className="row">
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12">
                                        <p>from</p>
                                        <DatePicker className="form-control" name="from"
                                            dateFormat="dd-MM-yyyy"
                                            selected={this.state.from}
                                            onChange={this.handleStartDateChange}
                                        />
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <p>To </p>
                                        <DatePicker className="form-control" name="to"
                                            dateFormat="dd-MM-yyyy"
                                            selected={this.state.to}
                                            onChange={this.handleEndDateChange}
                                        />
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <button style={{color: '#fff',marginTop: '50px'}} type="submit" className="pur">Search</button>
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <button style={{color: '#fff',marginTop: '50px'}} type="button" className="pur" onClick={() => this.clearAll()}>Clear</button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                                <div className="maain-tabble" key='users'>
                                    
                                { (true) ?
                                // { (this.state.users && this.state.users.length>0) ?
                                
                                    <DataTable
                                        data={this.state.users}
                                        columns={[
                                            //  { title: "ID", data: "id", },
                                            { title: "Date", data: "created_at" },
                                            { title: "UserName", data: "name" },
                                            { title: "Booking ID", data: "booking_id" },
                                            { title: "booking status", "render": function ( data, type, row ) {
                                                if(row.booking_status*1 == 4)
                                                    return '<label class="badge badge-success">Completed</label>';
                                                else 
                                                return '<label class="badge badge-danger">Cancelled</label>';
                                            }
                                        },
                                       
                                        { title: "Security Deposit", "render": function ( data, type, row ) {
                                            return '£'+row.security_deposit;
                                      }},
                                        { title: "Operator Amount", "render": function ( data, type, row ) {
                                            return '£'+row.amount;
                                        }},
                                        {
                                            title: "Payment Status",
                                            mData: "Action",
                                            targets: 0,
                                           // visible:false,
                                            cellType: "td",
                                            createdCell: (td, cellData, rowData, row, col) => {
                                                ReactDOM.render(
                                                    // <label class="form-check-label">
                                                    //     <input onClick={() => { this.toggleModal(rowData)}} class="form-check-input" type="checkbox" ></input>
                                                    //     Security Deposit Refunded
                                                    // </label>
                                                    
                                                    <select onClick={(e) => { this.toggleModal(rowData, e)}}>
                                                        <option selected={rowData.is_refund==0} value="0">Select...</option>
                                                        <option selected={rowData.is_refund==1} value="1">Security Deposit Refunded</option>
                                                                                                            </select>
                                                    , td);
                                            }
                                        },
                                            {
                                                title: "View",
                                                mData: "Action",
                                                targets: 0,
                                                cellType: "td",
                                                createdCell: (td, cellData, rowData, row, col) => {
                                                    ReactDOM.render(
                                                        <div className="btn-group mr-1 mb-1">
                                                            <button type="button" className="btn  btn-drop-table btn-sm"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i
                                                                className="fa fa-ellipsis-v"></i></button>
                                                            <div className="dropdown-menu" x-placement="bottom-start">
                                                                <a className="dropdown-item" 
                                                                //href={'/admin/quotations/completed/'+rowData.id}
                                                                
                                                                    onClick={ () => this.props.history.push('/payments/view-user/'+rowData.booking_id)}
                                                                   ><i
                                                                    className="fa fa-eye"></i>View</a>
                                                            </div>
                                                        </div>, td);
                                                }
                                            }
                                        ]}
                                        class="table table-striped table-bordered"/> 
                                        
                                        : <p>No Record Found!</p>
                                }
                                
                                </div>
                                
                                <div className="login-fail-main user">
                                    <div className="featured inner">
                                    <div className="modal fade bd-example-modal-lg" tabIndex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div className="modal-dialog modal-lg">
                                        <div className="modal-content">
                                            <button type="button" className="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            <div className="payment-modal-main">
                                            <div className="payment-modal-inner"> <img src="images/modal-2.png" className="img-fluid" alt="" />
                                                <h3>Are you sure you want to change Payment Status? </h3>
                                                <form ref={c => { this.form = c }} onSubmit={this.handleRefundUser}>
                                                <div className="row">
                                                <div className="col-12 text-center">
                                                    <input type="hidden" name="booking_id" value={this.state.booking_id}/>
                                                    <button type="button" data-dismiss="modal" className="can">Cancel</button>
                                                    <button type="submit" className="con">Change status</button>
                                                </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                               
                                </div>
                                <div className="tab-pane" id="tab36" aria-labelledby="base-tab36">
                                <div className="top">
                                    <div className="row">
                                    <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 "> <a style={{color: '#fff'}} onClick={ () => this.handleRedirect('/payments/package')} type="button" className="pur">Package Log</a> </div>
                                    </div>
                                    <div className="row">
                                    <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 "> <a style={{color: '#fff'}} onClick={ () => this.handleRedirect('/payments/mypayments')} type="button" className="yel">My Payment Log</a> </div>
                                    </div>
                                </div>
                                <div className="dates">
                                <form ref={c => { this.form = c }} onSubmit={this.handleSearch}>
                                    <div className="row">
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12">
                                        <p>from</p>
                                        <DatePicker className="form-control" name="from"
                                            dateFormat="dd-MM-yyyy"
                                            selected={this.state.from}
                                            onChange={this.handleStartDateChange}
                                        />
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <p>To </p>
                                        <DatePicker className="form-control" name="to"
                                            dateFormat="dd-MM-yyyy"
                                            selected={this.state.to}
                                            onChange={this.handleEndDateChange}
                                        />
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <button style={{color: '#fff',marginTop: '50px'}} type="submit" className="pur">Search</button>
                                    </div>
                                    <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                        <button style={{color: '#fff',marginTop: '50px'}} type="button" className="pur" onClick={() => this.clearAll()}>Clear</button>
                                    </div>
                                    </div>
                               </form>
                                </div>
                                <div className="maain-tabble">
                                { (true) ?
                                    <DataTable
                                        data={this.state.operators}
                                        columns={[
                                            //  { title: "ID", data: "id", },
                                            { title: "Date", data: "created_at" },
                                            { title: "UserName", data: "name" },
                                            { title: "Booking ID", data: "id" },
                                            { title: "booking_status", "render": function ( data, type, row ) {
                                                if(row.booking_status*1 == 4)
                                                    return '<label class="badge badge-success">Completed</label>';
                                            }
                                        },
                                        { title: "Security Deposit", "render": function ( data, type, row ) {
                                            return '£'+row.security_deposit;
                                      }},
                                        { title: "Operator Amount", "render": function ( data, type, row ) {
                                            return '£'+row.amount;
                                        }},
                                        {
                                            title: "Payment Status",
                                            mData: "Action",
                                            targets: 0,
                                            cellType: "td",
                                            createdCell: (td, cellData, rowData, row, col) => {
                                                ReactDOM.render(
                                                    <select onClick={() => {this.toggleModalOperator(rowData)}}>
                                                         <option selected={rowData.is_paid==0}>Select...</option>
                                                        <option selected={rowData.is_paid==1} value="1">Amount Paid</option>
                                                        {/* <option value="0">Not Refunded</option> */}
                                                    </select>, td);
                                            }
                                        },

                                            {
                                                title: "View",
                                                mData: "Action",
                                                targets: 0,
                                                cellType: "td",
                                                createdCell: (td, cellData, rowData, row, col) => {
                                                    ReactDOM.render(
                                                        <div className="btn-group mr-1 mb-1">
                                                            <button type="button" className="btn  btn-drop-table btn-sm"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i
                                                                className="fa fa-ellipsis-v"></i></button>
                                                            <div className="dropdown-menu" x-placement="bottom-start">
                                                                <a className="dropdown-item"
                                                                    onClick={ () => this.props.history.push('/payments/view/'+rowData.booking_id)}><i
                                                                    className="fa fa-eye"></i>View</a>
                                                            </div>
                                                        </div>, td);
                                                }
                                            }
                                        ]}
                                        class="table table-striped table-bordered"
                                    /> : <p>No Record Found!</p>
                                }
                                </div>
                                </div>
                                <div className="login-fail-main user">
                                    <div className="featured inner">
                                    <div className="modal fade operatorModal" tabIndex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div className="modal-dialog modal-lg">
                                        <div className="modal-content">
                                            <button type="button" className="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            <div className="payment-modal-main">
                                            <div className="payment-modal-inner"> <img src="images/modal-2.png" className="img-fluid" alt="" />
                                                <h3>Are you sure you want to change Payment Status? </h3>
                                                <form ref={c => { this.form = c }} onSubmit={this.handlePayOperator}>
                                                <div className="row">
                                                <div className="col-12 text-center">
                                                    <input type="hidden" name="booking_id" value={this.state.booking_id}/>
                                                    <button type="button" data-dismiss="modal" className="can">Cancel</button>
                                                    <button type="submit" className="con">Change status</button>
                                                </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            </div>
                            </div>
                            </div>
                        </div>
                </div>
            </section>
            


            </div>
            );
    }
}

export default withRouter(Listing);
