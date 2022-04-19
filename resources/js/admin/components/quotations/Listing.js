import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
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
            bookings: [],
            accepted: [],
            confirmed: [],
            completed: [],
            cancelled: [],
            path: ''
        }
         this.fetchQuotations = this.fetchQuotations.bind(this);
         this.handleClick = this.handleClick.bind(this);
         this.handleStartDateChange = this.handleStartDateChange.bind(this);
         this.handleEndDateChange = this.handleEndDateChange.bind(this);
         this.handleSubmit = this.handleSubmit.bind(this);
         this.handleSearch = this.handleSearch.bind(this);
         this.handleSearchConfirmed = this.handleSearchConfirmed.bind(this);
         this.handleSearchCompleted = this.handleSearchCompleted.bind(this);
         this.handleSearchCancelled = this.handleSearchCancelled.bind(this);
         this.clearAll = this.clearAll.bind(this);
    }



    componentDidMount() {
        this.fetchQuotations();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'pending'){
            this.props.history.push("/quotations/pending"+id);
        }
    }

    handleRedirect = (path) => {
      this.setState({path: path});
    }

    fetchQuotations(){
        var url = 'api/quotations';
        axios.get(url)
            .then((response) => {
                console.log('response', response);
                this.setState({ bookings: response.data.bookings});
                this.setState({ accepted: response.data.accepted});
                this.setState({ confirmed: response.data.confirmed});
                this.setState({ completed: response.data.completed});
                this.setState({ cancelled: response.data.cancelled});
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
    
      const data = new FormData(event.target);
       axios.get(`api/quotations?from=${dateFormat(this.state.from, "yyyy-mm-dd")}&to=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
          .then((response) => {
             this.setState({ bookings: response.data.bookings}, 
                  () => { console.log(this.state,"bookings");
              });
              this.forceUpdate();
             // console.log('count',this.state.bookingss.length);
          })
          .catch((error) => {
              console.log(error);
          });
  }

  handleSearch(event){
      event.preventDefault();
      const data = new FormData(event.target);
      axios.get(`api/quotations?start=${dateFormat(this.state.from, "yyyy-mm-dd")}&end=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
          .then((response) => {
              this.setState({ accepted: response.data.accepted}, 
                  () => { console.log("state",this.state);
              });
           //   console.log('count',this.state.users.length);
          })
          .catch((error) => {
              console.log(error);
          });
  }

  handleSearchConfirmed(event){
    event.preventDefault();
    const data = new FormData(event.target);
    axios.get(`api/quotations?c_from=${dateFormat(this.state.from, "yyyy-mm-dd")}&c_to=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
        .then((response) => {
            this.setState({ confirmed: response.data.confirmed}, 
                () => { console.log("state",this.state);
            });
         //   console.log('count',this.state.users.length);
        })
        .catch((error) => {
            console.log(error);
        });
}

handleSearchCompleted(event){
    event.preventDefault();
    const data = new FormData(event.target);
    axios.get(`api/quotations?co_from=${dateFormat(this.state.from, "yyyy-mm-dd")}&co_to=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
        .then((response) => {
            this.setState({ completed: response.data.completed}, 
                () => { console.log("state",this.state);
            });
         //   console.log('count',this.state.users.length);
        })
        .catch((error) => {
            console.log(error);
        });
}

handleSearchCancelled(event){
    event.preventDefault();
    const data = new FormData(event.target);
    axios.get(`api/quotations?cn_from=${dateFormat(this.state.from, "yyyy-mm-dd")}&cn_to=${dateFormat(this.state.to, "yyyy-mm-dd")}`)
        .then((response) => {
            this.setState({ cancelled: response.data.cancelled}, 
                () => { console.log("state",this.state);
            });
         //   console.log('count',this.state.users.length);
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
      if (this.state.path) {
        return <Redirect push to={this.state.path} />;
      }
        return (
            <>
            <Helmet> <title>Minibus - Quotations</title> </Helmet>
            
            <section id="configuration" className="search view-cause  add-operator operator-list">
                <div className="row">
              <div className="col-12">
                <div className="card rounded pad-20">
                  <div className="card-content collapse show">
                    <div className="card-body table-responsive card-dashboard">
                      <div className="row">
                        <div className="col-md-6 col-12">
                          <h1 className="pull-left">quotations</h1>
                        </div>
                         <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                            <div className="breadcrumb-wrapper col-12">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><Link to="dashboard">Home</Link></li>
                                    <li className="breadcrumb-item active">All Quotations</li>
                                </ol>
                            </div>
                       </div>
                      </div>
                     
                      <ul className="nav nav-tabs nav-underline no-hover-bg">
                        <li className="nav-item"> <a className="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" aria-expanded="true">Quotation Requests</a> </li>
                        <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab36" data-toggle="tab" aria-controls="tab36" href="#tab36" aria-expanded="false">Awaiting Confirmation</a> </li>
                        <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab37" data-toggle="tab" aria-controls="tab37" href="#tab37" aria-expanded="false">Quotations Accepted</a> </li>
                        <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab38" data-toggle="tab" aria-controls="tab38" href="#tab38" aria-expanded="false">Quotations Completed</a> </li>
                        <li className="nav-item"> <a className="nav-link  second-tab" id="base-tab39" data-toggle="tab" aria-controls="tab39" href="#tab39" aria-expanded="false">Cancelled Requests</a> </li>
                      </ul>
                      <div className="tab-content ">
                        <div role="tabpanel" className="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
                          <div className="row">
                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                              <div className="top"> 
                              <a className="yel" style={{color: '#fff'}} onClick={ () => this.handleRedirect('/quotations/stats')} type="button">Quotations Statistics</a> 
                              </div>
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
                          <div className="clearfix"></div>
                          <div className="maain-tabble">
                          { (true) ?
                              <DataTable
                                  data={this.state.bookings}
                                  columns={[
                                      { title: "ID", data: "id", },
                                      { title: "Date", data: "created_at" },
                                      { title: "Booking ID", data: "id" },
                                      { title: "Pick up location", data: "pickup_address" },
                                      { title: "mobile no", data: "contact_phone" },
                                      { title: "status", "render": function ( data, type, row ) {
                                          if(row.status*1 == 0)
                                              return '<label class="badge badge-primary">PENDING</label>';
                                      }
                                  },
                                      {
                                          title: "Action",
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
                                                              onClick={ () => this.props.history.push('/quotations/pending/'+rowData.id)}><i
                                                              className="fa fa-eye"></i>View</a>
                                                      </div>
                                                  </div>, td);
                                          }
                                      }
                                  ]}
                                  noDataText="No Record Found!"
                                  class="table table-striped table-bordered"
                              /> : <p>No Record Found!</p>
                          }
                          </div>
                        </div>
                        <div className="tab-pane " id="tab36" aria-labelledby="base-tab36">
                          <div className="row">
                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                            <div className="top"> 
                              <a className="yel" style={{color: '#fff'}} onClick={ () => this.handleRedirect('/quotations/stats')} type="button">Quotations Statistics</a> 
                              </div>
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
                          <div className="clearfix"></div>
                          <div className="maain-tabble">
                          {  (true) ?
                                <DataTable
                                    data={this.state.accepted}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "created_at" },
                                        { title: "Booking ID", data: "id" },
                                        { title: "Pick up location", data: "pickup_address" },
                                        { title: "mobile no", data: "contact_phone" },
                                        { title: "status", "render": function ( data, type, row ) {
                                            if(row.status*1 == 1)
                                                return '<label class="badge badge-primary">Accepted</label>';
                                        }
                                    },
                                        {
                                            title: "Action",
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
                                                                onClick={ () => this.props.history.push('/quotations/accepted/'+rowData.id)}><i
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
                        <div className="tab-pane " id="tab37" aria-labelledby="base-tab37">
                          <div className="row">
                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                              <div className="top"> <a href="a-quotations-statistics.html" className="yel">Quotations Statistics</a> </div>
                            </div>
                          </div>
                          <div className="dates">
                          <form ref={c => { this.form = c }} onSubmit={this.handleSearchConfirmed}>
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
                          { (true) ?
                                <DataTable
                                    data={this.state.confirmed}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "created_at" },
                                        { title: "Booking ID", data: "id" },
                                        { title: "Pick up location", data: "pickup_address" },
                                        { title: "mobile no", data: "contact_phone" },
                                        { title: "status", "render": function ( data, type, row ) {
                                            if(row.status*1 == 2)
                                                return '<label class="badge badge-primary">Confirmed</label>';
                                        }
                                    },
                                        {
                                            title: "Action",
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
                                                                onClick={ () => this.props.history.push('/quotations/confirmed/'+rowData.id)}><i
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
                        <div className="tab-pane " id="tab38" aria-labelledby="base-tab38">
                          <div className="row">
                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                            <div className="top"> 
                              <a className="yel" style={{color: '#fff'}} onClick={ () => this.handleRedirect('/quotations/stats')} type="button">Quotations Statistics</a> 
                              </div>
                            </div>
                          </div>
                          <div className="dates">
                          <form ref={c => { this.form = c }} onSubmit={this.handleSearchCompleted}>
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
                          { (true) ?
                                <DataTable
                                    data={this.state.completed}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "created_at" },
                                        { title: "Booking ID", data: "id" },
                                        { title: "Pick up location", data: "pickup_address" },
                                        { title: "mobile no", data: "contact_phone" },
                                        { title: "status", "render": function ( data, type, row ) {
                                            if(row.status*1 == 4)
                                                return '<label class="badge badge-success">completed</label>';
                                        }
                                    },
                                        {
                                            title: "Action",
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
                                                                onClick={ () => this.props.history.push('/quotations/completed/'+rowData.id)}><i
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
                      <div className="tab-pane " id="tab39" aria-labelledby="base-tab39">
                        <div className="row">
                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                            <div className="top"> 
                              <a className="yel" style={{color: '#fff'}} onClick={ () => this.handleRedirect('/quotations/stats')} type="button">Quotations Statistics</a> 
                              </div>
                            </div>
                          </div>
                          <div className="dates">
                          <form ref={c => { this.form = c }} onSubmit={this.handleSearchCancelled}>
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
                          { (true) ?
                                <DataTable
                                    data={this.state.cancelled}
                                    columns={[
                                        { title: "ID", data: "id", },
                                        { title: "Date", data: "created_at" },
                                        { title: "Booking ID", data: "id" },
                                        { title: "Pick up location", data: "pickup_address" },
                                        { title: "mobile no", data: "contact_phone" },
                                        { title: "status", "render": function ( data, type, row ) {
                                            if(row.status*1 == 6)
                                                return '<label class="badge badge-danger">Cancelled</label>';
                                        }
                                    },
                                        {
                                            title: "Action",
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
                                                                onClick={ () => this.props.history.push('/quotations/cancelled/'+rowData.id)}><i
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

export default withRouter(Listing);
