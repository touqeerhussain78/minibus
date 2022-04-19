import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { Link, useHistory, withRouter, useParams } from 'react-router-dom';
import axios from 'axios';
import { Redirect } from 'react-router';
import Form from 'react-validation/build/form';
import Input from 'react-validation/build/input';
import toastr from 'toastr';
import { Helmet } from 'react-helmet'


const required = (value, props) => {
    if (!value || (props.isCheckable && !props.checked)) {
        return <span className="form-error is-visible">The Field is Required</span>;
    }
};

class Operator extends Component {

    constructor(props){
        super(props);
        this.state = {
            operator: [],
            path: ''
        }
        this.fetchOperatorStats = this.fetchOperatorStats.bind(this);
    }

    componentDidMount() {
        this.fetchOperatorStats();
    }

    handleSubmit(event){
        event.preventDefault();
        const data = new FormData(event.target);
        axios.post('/api/quotations/stats/operator/send/', data)
            .then((response) => {
                console.log(response);
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                    window.location.reload();
                }, 700);
            })
            .catch((error) => {

            });
    }

    fetchOperatorStats(){
        axios.get('/api/quotations/stats/operator/'+this.props.id)
            .then((response) => {
                console.log("response", response);
                this.setState({operator: response.data.operator} );
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
            <Helmet> <title>Minibus - Operator Quotations</title> </Helmet>
            
            <section id="configuration" className="search view-cause operator-list q-state">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row">
                            <div className="col-md-6 col-12">
                            <h1 className="pull-left">Operator Statistics</h1>
                            </div>
                        </div>
                        
                        <div className="user-detail">
                        <div className="row">
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-user"></i>Operator Name</label>
                                    <p>{ this.state.operator.name}</p>
                                </div>
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-envelope"></i>Email</label>
                                    <p>{ this.state.operator.email }</p>
                                </div>
                            <div className="col-xl-4 col-md-6 col-12">
                                <label ><i className="fa fa-phone"></i>Phone</label>
                                    <p>{ this.state.operator.phone }</p>
                                </div> 
                        </div> 
                            <div className="row">
                                <div className="col-12 text-center">
                                <a onClick={ () => this.handleRedirect('/operators/view/'+this.props.id)} type="button" className="pur-btn"> View Profile</a>
                                    <a href="javascript;" data-toggle="modal" data-target="#exampleModalCenter" className="pur-btn"> Send Operator Quotes</a>
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
                            <td>{ this.state.operator.sent }</td> 
                            <td>{ this.state.operator.accepted }</td> 
                            <td>{ this.state.operator.completed }</td> 
                            <td>{ this.state.operator.cancelled }</td> 
                            <td>£{ this.state.operator.total }</td> 
                            </tr>
                        </tbody>
                        </table>
                    
                        </div>   
                        </div>
                        
                        <div className="login-fail-main user">
                            <div className="featured inner">
                            <div className="modal fade bd-example-modal-lg" id="exampleModalCenter" tabIndex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    <div className="payment-modal-main">
                                    <div className="payment-modal-inner"> <img src="images/quote.png" className="img-fluid" alt="" />
                                        <h2>Send Quotes</h2>
                                        
                                        <Form ref={c => { this.form = c }} onSubmit={this.handleSubmit}>
                                            <div className="row">
                                                <div className="col-md-4 col-12">
                                                    <p>Number of Quotes to Send</p>
                                                </div>
                                                <div className="col-md-8 col-12">
                                                <Input type="hidden" name="operator_id" value={ this.state.operator.id } />
                                                <input type="number" name="quotes" required class="form-control"/>
                                                </div>
                                                <div className="col-12 text-center">
                                                <button className="yes" type="submit">Send Quotes</button>
                                                </div>
                                                </div>
                                        </Form>
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

export default withRouter(Operator);
