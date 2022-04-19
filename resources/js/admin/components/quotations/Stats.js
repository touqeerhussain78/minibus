import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import dateFormat from 'dateformat';
import { Helmet } from 'react-helmet'

class Stats extends Component {

    constructor(props){
        super(props);
        this.state = {
            bookings: [],
            operators: []
        }
         this.fetchQuotationStats = this.fetchQuotationStats.bind(this);
         this.handleClick = this.handleClick.bind(this);
         this.handleStartDateChange = this.handleStartDateChange.bind(this);
         this.handleEndDateChange = this.handleEndDateChange.bind(this);
         this.handleSubmit = this.handleSubmit.bind(this);
         this.handleSearch = this.handleSearch.bind(this);
         this.clearAll = this.clearAll.bind(this);
    }



    componentDidMount() {
        this.fetchQuotationStats();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'stats'){
            this.props.history.push("/quotations/stats");
        }
    }

    fetchQuotationStats(){
        var url = 'api/quotations/stats';
        axios.get(url)
            .then((response) => {
                console.log('response', response);
                this.setState({ bookings: response.data.users});
                this.setState({ operators: response.data.operators});
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
                    () => { console.log("state",this.state);
                });
                console.log('count',this.state.users.length);
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
                this.setState({ users: response.data.users}, 
                    () => { console.log("state",this.state);
                });
                console.log('count',this.state.users.length);
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
 

    render(){
        return (
            <>
            <Helmet> <title>Minibus - Quotation Statistics</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row">
                            <div className="col-md-6 col-12">
                                <h1 className="pull-left">quotations Statistics</h1>
                            </div>
                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                            <div className="breadcrumb-wrapper col-12">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><Link to="dashboard">Home</Link></li>
                                    <li className="breadcrumb-item"><Link to="quotations">Quotations</Link></li>
                                    <li className="breadcrumb-item active">Quotations Statistics</li>
                                </ol>
                            </div>
                       </div>
                        </div>
                        
                        <ul className="nav nav-tabs nav-underline no-hover-bg">
                            <li className="nav-item"> <a className="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" aria-expanded="true">user</a> </li>
                            <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab36" data-toggle="tab" aria-controls="tab36" href="#tab36" aria-expanded="false">operator</a> </li> 
                        </ul>
                        <div className="tab-content ">
                            
                            <div role="tabpanel" className="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
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
                            <div className="clearfix"></div>
                            <div className="maain-tabble">
                            { this.state.bookings.length ?
                                <DataTable
                                    data={this.state.bookings}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "date" },
                                        { title: "Username", data: "name" },
                                        { title: "Quotations Requested", data: "requested" },
                                        { title: "Quotations Accepted", data: "accepted" },
                                        { title: "Trips Completed", data: "completed" },
                                        { title: "Request Cancelled", data: "cancelled" },
                                        { title: "Amount Paid", data: "paid" },
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
                                                                onClick={ () => this.props.history.push('/quotations/user/'+rowData.id)}><i
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
                            <div className="tab-pane" id="tab36" aria-labelledby="base-tab36"> 
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
                            <div className="clearfix"></div>
                            <div className="maain-tabble">
                              
                                { this.state.operators.length ?
                                <DataTable
                                    data={this.state.operators}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "date" },
                                        { title: "Username", data: "name" },
                                        { title: "Quotations Sent", data: "sent" },
                                        { title: "Quotations Ignored", data: "ignored" },
                                        { title: "Quotations Accepted", data: "accepted" },
                                        { title: "Quotations Rejected", data: "rejected" },
                                        { title: "Request Cancelled", data: "cancelled" },
                                        { title: "Trips Completed", data: "completed" },
                                        { title: "Quotations Remaining", data: "quotations" },
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
                                                                onClick={ () => this.props.history.push('/quotations/operator/'+rowData.id)}><i
                                                                className="fa fa-eye"></i>View</a>
                                                        </div>
                                                    </div>, td);
                                            }
                                        }
                                        
                                    ]}
                                    class="table table-striped table-bordered"
                                /> : ""
                            }
                            </div>
                                


                            </div> 
                        </div>   
                        </div>
                        
                        <div className="login-fail-main user">
                            <div className="featured inner">
                            <div className="modal fade bd-example-modal-lg" tabIndex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    <div className="payment-modal-main">
                                    <div className="payment-modal-inner"> <img src="images/quote.png" className="img-fluid" alt="" />
                                        <h2>Send Quotes</h2>
                                        
                                        <form action="">
                                            <div className="row">
                                                
                                                <div className="col-md-4 col-12">
                                                    <p>Number of Quotes to Send</p>
                                                </div>
                                                <div className="col-md-8 col-12">
                                                <input type="password" name="" id="" placeholder="" className="form-control" />
                                                </div>
                                                <div className="col-12 text-center">
                                        <button className="yes" data-dismiss="modal" aria-label="Close">Send Quotes</button>
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
            </section> 
            </>
            );
    }
}

export default withRouter(Stats);
