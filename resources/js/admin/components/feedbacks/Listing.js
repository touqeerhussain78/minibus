import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import DataTable from "../Datatable";
import toastr from 'toastr';
import $ from "jquery";
import { Redirect } from 'react-router';
import { Helmet } from 'react-helmet'

class Listing extends Component {

    constructor(props){
        super(props);
        this.state = {
            feedbacks: [],
            path: ''
        }
         this.fetchFeedbacks = this.fetchFeedbacks.bind(this);
         this.handleClick = this.handleClick.bind(this);
    }



    componentDidMount() {
        this.fetchFeedbacks();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'view'){
            this.props.history.push("/feedbacks/view/"+id);
        }
    }

    handleRedirect = (path) => {
      this.setState({path: path});
    }

     fetchFeedbacks(){
        var url = 'api/feedbacks';
         axios.get(url)
            .then((response) => {
              
                this.setState({ feedbacks: response.data.feedbacks}, 
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

    render(){
      if (this.state.path) {
            console.log("path",this.state.path)
        return <Redirect push to={this.state.path} />;
      }
    
    
        return (
          <>
          <Helmet> <title>Minibus - Feedbacks</title> </Helmet>
          
            <section id="configuration" className="search view-cause operator-list q-state">
            <div className="row">
              <div className="col-12">
                <div className="card rounded pad-20">
                  <div className="card-content collapse show">
                    <div className="card-body table-responsive card-dashboard">
                      <div className="row">
                        <div className="col-12">
                          <h1 className="pull-left">Feedback List</h1>
                        </div>
                      </div> 
                        
                        <div className="top">
                        <div className="row">
                        
                        <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 ">
                                 <a style={{color: '#fff'}} onClick={ () => this.handleRedirect('/feedbacks/reports')} type="button" className="yel">View reports</a>  </div>
                        </div>
                            </div>
                      
                       {/* <div className="dates">
                            <div className="row">
                              <div className="col-xl-3 offset-xl-6 offset-lg-5 offset-md-4 col-lg-3 col-md-4 col-12 ">
                                <p>from</p>
                                <input id="datepicker-1"  placehodler="Form" className="form-control"/>
                              </div>
                              <div className="col-xl-3 col-lg-3 col-md-4 col-12 ">
                                <p>To </p>
                                <input id="datepicker-2" placehodler="to"  className="form-control"/>
                              </div>
                           </div>
                           </div> */}
                        
                          <div className="maain-tabble">
                          { this.state.feedbacks.length ?
                              <DataTable
                                  data={this.state.feedbacks}
                                  columns={[
                                      { title: "ID", data: "id", },
                                      // { title: "From", data: "user.name" },
                                      { title: "Name", "render": function ( data, type, row ) {
                                        if(row.type*1 == 1 || row.type == 2)
                                        return '<span data-toggle="popover" data-content="johny" class="circle" style="background: #f61454;">'+row.user.name.charAt(0)+'</span> '+row.user.name;  
                                        else
                                        return "-";           
                                      }},
                                      { title: "Type", "render": function ( data, type, row ) {
                                        if(row.type*1 == 1)
                                          return '<label class="badge badge-primary">User</label>';
                                        else if(row.type == 2)
                                          return '<label class="badge badge-info">Operator</label>';
                                        else
                                          return '<label class="badge badge-success">Guest User</label>';
                                      }
                                      },
                                      { title: "Subject", data: "subject" },
                                      { title: "Date", data: "created_at" },
                                      
                                  { title: "Description", data: "message" },
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
                                                          onClick={ () => this.props.history.push('/feedbacks/view/'+rowData.id)}><i
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
              </section>

                          </>
            );
    }
}

export default withRouter(Listing);
