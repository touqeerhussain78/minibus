import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import { Redirect } from 'react-router';
import { Helmet } from 'react-helmet'

class User extends Component {

    constructor(props){
        super(props);
        this.state = {
            user: [],
            path: ''
        }
        this.fetchUserStats = this.fetchUserStats.bind(this);
    }
    componentDidMount() {
        this.fetchUserStats();
    }

    fetchUserStats(){
        axios.get('/api/quotations/stats/user/'+this.props.id)
            .then((response) => {
                console.log("response", response);
                this.setState({user: response.data.user} );
            })
            .catch((error) => {
                console.log(error);
            });
    }

    handleRedirect = (path) => {
        this.setState({path: path});
      }
   
    render(){
        if (this.state.path) {
            return <Redirect push to={this.state.path} />;
        }
        return (
            <>
            <Helmet> <title>Minibus - Payments</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row">
                            <div className="col-md-6 col-12">
                                <h1 className="pull-left">USER STATISTICS</h1>
                            </div>
                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                            <div className="breadcrumb-wrapper col-12">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><Link to="dashboard">Home</Link></li>
                                    <li className="breadcrumb-item"><Link to="quotations">Quotations</Link></li>
                                    <li className="breadcrumb-item active">User Quotations Statistics</li>
                                </ol>
                            </div>
                       </div>
                       </div>
                        
                        <div className="user-detail">
                        <div className="row">
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-user"></i>Username</label>
                                    <p>{ this.state.user.name}</p>
                                </div>
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-envelope"></i>email</label>
                                    <p>{ this.state.user.email }</p>
                                </div>
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-phone"></i>phone</label>
                                    <p>{ this.state.user.phone }</p>
                                </div> 
                        </div> 
                            <div className="row">
                                <div className="col-12 text-center">
                                  <a onClick={ () => this.handleRedirect('/users/view/'+this.props.id)} type="button" className="pur-btn"> View Profile</a>
                                </div>
                            </div>
                            </div>
                            <div className="maain-tabble">
                        <table className="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Total Booking Requested</th>
                            <th>Total Bookings Accepted</th>
                            <th>Total Booking Completed</th>
                            <th>Total Booking Cancelled</th> 
                            <th>Amount Paid</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>01</td> 
                            <td>{ this.state.user.requested }</td> 
                            <td>{ this.state.user.accepted }</td> 
                            <td>{ this.state.user.completed }</td> 
                            <td>{ this.state.user.cancelled }</td> 
                            <td>£{ this.state.user.paid }</td> 
                            </tr>
                        </tbody>
                        </table>
                    
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

export default withRouter(User);
