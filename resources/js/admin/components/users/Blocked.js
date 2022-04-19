import React, {Component} from 'react';
import ReactDOM from 'react-dom'
import { Link, useHistory, withRouter, useParams } from 'react-router-dom'
import axios from 'axios';
import DataTable from "../Datatable";
import toastr from 'toastr';
import $ from "jquery";
import { Helmet } from 'react-helmet'

class Blocked extends Component {

    constructor(props){
        super(props);
        this.state = {
            users: [],
            activeid: '',
        }
        this.fetchUsers = this.fetchUsers.bind(this);
        this.handleClick = this.handleClick.bind(this);
        this.handleBlockUser = this.handleBlockUser.bind(this);
    }



    componentDidMount() {
        this.fetchUsers();
    }


    handleClick(type, id){
        let history = useHistory();
        if(type == 'view'){
            this.props.history.push("/user/view"+id);
        }else{
            history.push("/user/edit"+id);
        }
    }

    handleBlockUser(){
        axios.get('api/users/change-status/'+this.state.activeid)
            .then((response) => {
                toastr.success(response.message, 'Success');
                $(".bd-example-modal-lg").modal("hide");
                this.props.history.push("/users");
            })
            .catch((error) => {
                console.log(error);
            });
    }

    fetchUsers(blocked=false){
        var url = 'api/users?blocked=true';
        axios.get(url)
            .then((response) => {
                this.setState({ users: response.data});
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
            <Helmet> <title>Minibus - Blocked Users</title> </Helmet>
            
            <section id="configuration" className="search view-cause  add-operator operator-list">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-lg-6 col-12">
                                            <h1 className="pull-left">Blocked User list</h1>
                                        </div>
                                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-lg-6 col-12">
                                            <div className="breadcrumb-wrapper col-12">
                                                <ol className="breadcrumb">
                                                    <li className="breadcrumb-item"><Link to="user">Users</Link></li>
                                                    <li className="breadcrumb-item active">Blocked Users</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="top">
                                        <div className="row">
                                            <div className="col-xl-4 offset-xl-8 offset-lg-7 offset-md-4 col-lg-5 col-md-8 col-12 order-lg-1 order-2">
                                                <a className="pur" onClick={ () => this.props.history.push('/users')}><i className="pur"></i>All Users</a>
                                            </div>
                                            <div className="col-12 d-lg-flex d-block align-items-center justify-content-between order-lg-2 order-1">
                                                <div className="box">
                                                    <div className="media align-items-center"> <i className="fa fa-user-circle" />
                                                        <div className="media-body">
                                                            <h2>Total Blocked users</h2>
                                                        </div>
                                                        <h3>{this.state.users.length}</h3>
                                                    </div>
                                                </div>
                                                {/* <Link to="/users/add" className="yel l"><i className="fa fa-plus-circle" /> Add User</Link> */}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="clearfix" />
                                    <div className="maain-tabble">
                                        { this.state.users.length ?
                                            <DataTable
                                                data={this.state.users}
                                                columns={[
                                                    { title: "ID", data: "id", },
                                                    { title: "Name", data: "name" },
                                                    { title: "username", data: "username" },
                                                    { title: "email", data: "email" },
                                                    { title: "mobile no", data: "phone_no" },
                                                    { title: "status", "render": function ( data, type, row ) {
                                                            if(row.status*1 == 0)
                                                                return '<label class="badge badge-primary">PENDING</label>';
                                                            if(row.status*1 == 1)
                                                                return '<label class="badge badge-success">APPROVED</label>';
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
                                                                            aria-expanded="false"><i
                                                                        className="fa fa-ellipsis-v"></i></button>
                                                                    <div className="dropdown-menu" x-placement="bottom-start">
                                                                        <a className="dropdown-item"
                                                                           onClick={ () => this.props.history.push('/users/view/'+rowData.id)}><i
                                                                            className="fa fa-eye"></i>View</a>
                                                                        <a className="dropdown-item"
                                                                           onClick={ () => this.props.history.push('/users/edit/'+rowData.id)}><i
                                                                            className="fa fa-pencil"></i>Edit </a>
                                                                        <a className="dropdown-item" href="#"
                                                                           onClick={() => this.setState({ activeid: rowData.id})}
                                                                           data-toggle="modal"
                                                                           data-target=".bd-example-modal-lg"><i
                                                                            className="fa fa-ban"></i>Unblock </a>
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
                                            <h3>Are you sure you want to Un block this user?</h3>
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
            </section>
</>
        );
    }
}

export default withRouter(Blocked);
