import React, {Component} from 'react';
import ReactDOM from 'react-dom'
import { Link, useHistory, withRouter, useParams } from 'react-router-dom'
import axios from 'axios';
import DataTable from "../Datatable";
import toastr from 'toastr';
import $ from "jquery";
import { Helmet } from 'react-helmet';
import ReactPaginate from 'react-paginate';

class Listing extends Component {

    constructor(props){
        super(props);
        this.state = {
            operators: [],
            activeid: '',
            total: '',
            page: 1
        }
        this.fetchUsers = this.fetchUsers.bind(this);
        this.handleClick = this.handleClick.bind(this);
        this.handleBlockUser = this.handleBlockUser.bind(this);
        this.handleActiveUser = this.handleActiveUser.bind(this);
        this.handleRejectUser = this.handleRejectUser.bind(this);
        this.onPage = this.onPage.bind(this);
    }


    componentDidMount() {
        this.fetchUsers();
    }

    handleClick(type, id){
        let history = useHistory();
        if(type == 'view'){
            this.props.history.push("/operator/view"+id);
        }else{
            history.push("/operator/edit"+id);
        }
    }

    handleBlockUser(){
        axios.get('api/operator/change-status/'+this.state.activeid)
            .then((response) => {
                toastr.success("Operator blocked successfully", 'Success');
                $('.bd-example-modal-lg').modal('hide');
                 setTimeout(()=> {
                    this.props.history.push('/operators/blocked');
                }, 700);
                
            })
            .catch((error) => {
                console.log(error);
            });
    }

    handleActiveUser(){
        axios.get('api/operator/change-status/'+this.state.activeid+'?status=1')
            .then((response) => {
                toastr.success("Operator is approved", 'Success');
                $('.activeModal').modal('hide');

                 setTimeout(()=> {
                    this.props.history.push('/operators');
                }, 700);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    handleRejectUser(){
        axios.get('api/operator/change-status/'+this.state.activeid+'?status=3')
            .then((response) => {
                toastr.success("Operator is rejected", 'Success');
                $('.rejectModal').modal('hide');
               setTimeout(()=> {
                    this.props.history.push('/operators');
                }, 700);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    fetchUsers(){
        const { page } = this.state;
        var url = `api/operator?page=${page}`;
        
        //params['page'] = page;
        axios.get(url, { page })
            .then((response) => {
                
                //return;
                this.setState({ 
                    operators: response.data.operators,
                    total: response.data.total
                });
                console.log(this.state.operators.data, 'operators');
            })
            .catch((error) => {
                console.log(error);
            });
    }
    async onPage(selectedPage){
        console.log(selectedPage,'select');
        let page = selectedPage.selected + 1;
        this.setState({ page: selectedPage.selected + 1 });
        await axios.get(`api/operator?page=${ page }`)
            .then((response) => {
                
                //return;
               this.setState({ 
                    operators: response.data.operators,
                    total: response.data.total
                }, () => {
                    console.log(this.state.operators.data, 'operators');
                  }); 
              //  console.log(this.state.operators.data, 'operators');
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
        return (
            <>
              <Helmet> <title>Minibus - Operators</title> </Helmet>
              
            <section id="configuration" className="search view-cause  add-operator operator-list">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body  card-dashboard">
                                    <div className="row">
                                        <div className="col-lg-6 col-12">
                                            <h1 className="pull-left">Operator list</h1>
                                        </div>
                                        {/* <div className="content-header-right breadcrumbs-right breadcrumbs-top col-lg-6 col-12">
                                            <div className="breadcrumb-wrapper col-12">
                                                <ol className="breadcrumb">
                                                    <li className="breadcrumb-item"><Link to="operators">Users</Link></li>
                                                    <li className="breadcrumb-item active">All Operators</li>
                                                </ol>
                                            </div>
                                        </div> */}
                                    </div>
                                    <div className="top">
                                        <div className="row">
                                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 order-lg-1 order-2">
                                                <a className="pur"  onClick={ () => this.props.history.push('/operators/blocked')}><i className="pur"></i>Blocked Operators</a>
                                            </div>
                                            <div className="col-12 d-lg-flex d-block align-items-center justify-content-between order-lg-2 order-1">
                                                <div className="box">
                                                    <div className="media align-items-center"> <i className="fa fa-user-circle" />
                                                        <div className="media-body">
                                                            <h2>Total Operators</h2>
                                                        </div>
                                                        <h3>{this.state.total}</h3>
                                                    </div>
                                                </div>
                                                <Link to="/operators/add" className="yel l"><i className="fa fa-plus-circle" /> Add Operator</Link>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="clearfix" />
                                    <div className="maain-tabble table-responsive">
                                         { this.state.operators && this.state.operators.data ? 
                                            <DataTable
                                                data={this.state.operators && this.state.operators.data}
                                                columns={[
                                                    { title: "ID", data: "id", },
                                                    { title: "Name", "render": function ( data, type, row ) {
                                                        if(!row.image)
                                                        return '<span data-toggle="popover" data-content="johny" class="circle" style="background: #f61454;">A</span> '+row.name;
                                                        else
                                                        return '<img src='+row.image+' class="circle" alt="image" style="height: 24px;width: 24px;"/> '+row.name;
                                                    }},
                                                    { title: "Company Name", data: "company_name" },
                                                    { title: "Email", data: "email" },
                                                    { title: "mobile no", data: "phone_no" },
                                                    { title: "Status", "render": function ( data, type, row ) {
                                                            console.log(row.status*1);
                                                            if(row.status*1 == 0)
                                                                return '<label class="badge badge-primary">PENDING</label>';
                                                            else if(row.status*1 == 1)
                                                                return '<label class="badge badge-success">APPROVED</label>';
                                                            else if(row.status*1 == 3)
                                                                return '<label class="badge badge-danger">Rejected</label>';
                                                            else
                                                                return '<label class="badge badge-danger">BLOCKED</label>';

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
                                                                            aria-expanded="false"><i className="fa fa-ellipsis-v"></i></button>
                                                                    <div className="dropdown-menu" x-placement="bottom-start">
                                                                    <a className="dropdown-item"
                                                                           onClick={ () => this.props.history.push('/operators/view/'+rowData.id)}><i
                                                                            className="fa fa-eye"></i>View</a>
                                                                    <a className="dropdown-item"
                                                                           onClick={ () => this.props.history.push('/operators/edit/'+rowData.id)}><i
                                                                            className="fa fa-pencil"></i>Edit </a>
                                                                    
                                                                    {(() => {
                                                                         if(rowData.status==0){
                                                                            return <a className="dropdown-item" href="#"
                                                                            onClick={() => this.setState({ activeid: rowData.id})}
                                                                            data-toggle="modal"
                                                                            data-target=".rejectModal"><i
                                                                             className="fa fa-times"></i>Reject </a>
                                                                          }
                                                                    })()}
                                                                     {(() => {
                                                                         if(rowData.status==1){
                                                                            return <a className="dropdown-item" href="#"
                                                                            onClick={() => this.setState({ activeid: rowData.id})}
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"><i
                                                                             className="fa fa-ban"></i>block </a>
                                                                          }
                                                                    })()}
                                                                    {(() => {
                                                                        if(rowData.status==0){
                                                                            return <a className="dropdown-item" href="#"
                                                                            onClick={() => this.setState({ activeid: rowData.id})}
                                                                            data-toggle="modal"
                                                                            data-target=".activeModal"><i
                                                                             className="fa fa-check"></i>Approve </a>
                                                                          }
                                                                          else if(rowData.status==3){
                                                                            return <a className="dropdown-item" href="#"
                                                                            onClick={() => this.setState({ activeid: rowData.id})}
                                                                            data-toggle="modal"
                                                                            data-target=".activeModal"><i
                                                                             className="fa fa-check"></i>Approve </a>
                                                                          }
                                                                        })()}
                                                                        
                                                                        
                                                                        
                                                                        
                                                                    </div>
                                                                </div>, td);
                                                        }
                                                    }
                                                ]}
                                                class="table table-striped table-bordered"
                                                defaultSortAsc={false}
                                            /> : <p>No Record Found!</p>
                                        }
                                    <ReactPaginate
                                        containerClassName="pagination justify-content-end"
                                        pageClassName="paginate_button page-item"
                                        pageLinkClassName="page-link"
                                        activeClassName="active"
                                        previousClassName="paginate_button page-item previous"
                                        previousLinkClassName="page-link"
                                        nextClassName="paginate_button page-item next"
                                        nextLinkClassName="page-link"
                                        activeLinkClassName="paginate_button page-item"
                                        pageCount={this.state.operators && this.state.operators.last_page}
                                        onPageChange={this.onPage}
                                    />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="login-fail-main user">
                    <div className="featured inner">
                        <div className="modal fade bd-example-modal-lg" tabIndex={-1} role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div className="modal-dialog modal-lgg">
                                <div className="modal-content">
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div className="payment-modal-main">
                                        <div className="payment-modal-inner">
                                            <img src={window.base_url + '/administrator/images/modal-2.png'} className="img-fluid" alt=""/>
                                            <h3>Are you sure you want to block this user?</h3>
                                            <div className="row">
                                                <div className="col-12 text-center">
                                                    <button type="button" data-dismiss="modal" className="can">Cancel
                                                    </button>
                                                    <button type="button" onClick={this.handleBlockUser} className="con">confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="login-fail-main user">
                    <div className="featured inner">
                        <div className="modal fade activeModal" tabIndex={-1} role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div className="modal-dialog modal-lgg">
                                <div className="modal-content">
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div className="payment-modal-main">
                                        <div className="payment-modal-inner">
                                            <img src={window.base_url + '/administrator/images/modal-2.png'} className="img-fluid" alt=""/>
                                            <h3>Are you sure you want to Approve this operator?</h3>
                                            <div className="row">
                                                <div className="col-12 text-center">
                                                    <button type="button" data-dismiss="modal" className="can">Cancel
                                                    </button>
                                                    <button type="button" onClick={this.handleActiveUser} className="con">confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="login-fail-main user">
                    <div className="featured inner">
                        <div className="modal fade rejectModal" tabIndex={-1} role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div className="modal-dialog modal-lgg">
                                <div className="modal-content">
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div className="payment-modal-main">
                                        <div className="payment-modal-inner">
                                            <img src={window.base_url + '/administrator/images/modal-2.png'} className="img-fluid" alt=""/>
                                            <h3>Are you sure you want to reject this operator account?</h3>
                                            <div className="row">
                                                <div className="col-12 text-center">
                                                    <button type="button" data-dismiss="modal" className="can">Cancel
                                                    </button>
                                                    <button type="button" onClick={this.handleRejectUser} className="con">confirm</button>
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

export default withRouter(Listing);
