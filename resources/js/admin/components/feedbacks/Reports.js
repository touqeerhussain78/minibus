import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import toastr from 'toastr';
import $ from "jquery";
import { Redirect } from 'react-router';
import { Helmet } from 'react-helmet'

class Reports extends Component {

    constructor(props){
        super(props);
        this.state = {
            reports: [],
            path: ''
        }
         this.fetchReports = this.fetchReports.bind(this);
         this.handleClick = this.handleClick.bind(this);
    }



    componentDidMount() {
        this.fetchReports();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'report-view'){
            this.props.history.push("/feedbacks/report-view/"+id);
        }
    }

    handleRedirect = (path) => {
      this.setState({path: path});
    }

     fetchReports(){
        var url = 'api/feedbacks/reports';
         axios.get(url)
            .then((response) => {
              
                this.setState({ reports: response.data.reports}, 
                    () => { console.log("report",this.state);
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

    render(){
      if (this.state.path) {
            console.log("path",this.state.path)
        return <Redirect push to={this.state.path} />;
      }
    
    
        return (
            <>
            <Helmet> <title>Minibus - Reports</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state a-feedback">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row">
                            <div className="col-md-6">
                            <h1 className="">Reports</h1>
                            </div>
                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/feedbacks">feedbacks</Link></li>
                                                <li className="breadcrumb-item active"> Reports</li>
                                            </ol>
                                        </div>
                        </div>  
                            
                        
                        {/* <div className="dates">
                                <div className="row">
                                <div className="col-xl-3 col-12 ">
                                    <h2>report</h2>
                                    </div>
                                <div className="col-xl-3 offset-xl-3 offset-lg-4 offset-md-2 col-lg-4 col-md-4 col-12 ">
                                    <p>from</p>
                                    <input id="datepicker-1"  placehodler="Form" className="form-control"/>
                                </div>
                                <div className="col-xl-3 col-lg-4 col-md-4 col-12 ">
                                    <p>To </p>
                                    <input id="datepicker-2" placehodler="to"  className="form-control"/>
                                </div>
                            </div>
                            </div> */}
                            
                            <div className="maain-tabble">
                            { this.state.reports.length ?
                              <DataTable
                                  data={this.state.reports}
                                  columns={[
                                      { title: "ID", data: "id", },
                                      { title: "From", data: "user.name" },
                                      { title: "Date", data: "created_at" },
                                      
                                  { title: "Description", data: "comments" },
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
                                                          onClick={ () => this.props.history.push('/feedbacks/report-view/'+rowData.id)}><i
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
                    </div>
                    </div>
                
            </section>
</>
            );
    }
}

export default withRouter(Reports);
