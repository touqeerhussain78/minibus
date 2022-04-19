import React, {Component} from 'react';
import axios from "axios";
import toastr from 'toastr';
import $ from 'jquery';
import { Helmet } from 'react-helmet'
import {
    Link
} from "react-router-dom";
class Profile extends Component {
    constructor(props){
        super(props);
        this.user = window.user;
        this.state = {
            np : "",
            op: "",
            cnp: ""
        }
    }

    handlePasswordChange = () => {
        let password = {
            oldPassword: this.state.op,
            newPassword: this.state.np,
            confirmNewPassword: this.state.cnp,
        }
        axios.post('/api/change-password', password)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                $('#bd-example-modal-lg').modal('hide');
            })
            .catch((error) => {
                let e = error.response;
                let errors = e.data;
                console.log(errors);
                toastr.error(errors.error, 'Error');
                setTimeout(()=> {
                    document.body.classList.remove('loading-indicator');
                }, 1000);
            });
    }

    handlePasswordChangeState = (e) => {
        this.setState({ [e.target.name] : e.target.value });
    }

    render() {
        return (
            <>
            <Helmet> <title>Minibus - Profile</title> </Helmet>
            <section id="configuration" className=" admin-profile verfication-profile operator-detail search view-cause">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-md-6 col-12">
                                            <h1 className="pull-left">Profile</h1>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-xl-10 col-12 d-flex order-xl-1 order-2">
                                            <div className="attached">
                                                <img src={this.user.image} className="img-full" alt="" /> </div>
                                        </div>
                                        <div className="col-xl-2 col-12 text-md-right order-xl-1 order-1">
                                            <Link to='/edit-profile' className="edit">
                                            <i className="fa fa-edit" />edit profile</Link>
                                            <a href="#" className="pas" data-toggle="modal" data-target="#changepassword">change password</a> </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-12 col-md-6">
                                            <label><i className="fa fa-user-circle" />Name</label>
                                            <p>{this.user.name}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-envelope" />email</label>
                                            <p>{this.user.email}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-phone" />phone</label>
                                            <p>{this.user.phone_no}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-phone" />mobile</label>
                                            <p>{this.user.phone_no_1}</p>
                                        </div>
                                        <div className="col-12">
                                            <label><i className="fa fa-building" />Address</label>
                                            <p>{this.user.address}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-building" />city</label>
                                            <p>{this.user.city}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-globe" />country</label>
                                            <p>{this.user.country}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-globe" />state</label>
                                            <p>{this.user.state}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label><i className="fa fa-globe" />zipcode</label>
                                            <p>{this.user.zipcode}</p>
                                        </div>
                                    </div>
                                </div>
                                {/*block modal start here*/}
                                <div className="login-fail-main user">
                                    <div className="featured inner">
                                        <div className="modal fade bd-example-modal-lg" id="changepassword" tabIndex={-1} role="dialog"
                                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div className="modal-dialog modal-lgg">
                                                <div className="modal-content">
                                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                                    <div className="payment-modal-main">
                                                        <div className="payment-modal-inner"> <img src={window.asset_url + 'images/modal-1.png'} className="img-fluid" alt="" />
                                                            <h2>Change password</h2>
                                                                <div className="row">
                                                                    <div className="col-12 form-group"> <i className="fa fa-lock" />
                                                                        <input type="password" name="op" onChange={(e) => this.handlePasswordChangeState(e) } placeholder="current password" className="form-control" />
                                                                    </div>
                                                                    <div className="col-12 form-group"> <i className="fa fa-lock" />
                                                                        <input type="password" name="np" onChange={(e) => this.handlePasswordChangeState(e) }   placeholder="new password" className="form-control" />
                                                                    </div>
                                                                    <div className="col-12 form-group"> <i className="fa fa-lock" />
                                                                        <input type="password" name="cnp" onChange={(e) => this.handlePasswordChangeState(e) } placeholder="re-type password" className="form-control" />
                                                                    </div>
                                                                    <div className="col-12 text-center">
                                                                        <button type="button" onClick={this.handlePasswordChange} className="yes"  aria-label="Close">Save</button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/*block modal end here*/}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
       </>
        );
    }
}

export default Profile;
