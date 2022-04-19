import React, {Component} from 'react';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import { Helmet } from 'react-helmet'

class Pending extends Component {

    constructor(props){
        super(props);
        this.state = {
            quotation: [],
            time_left: '',
            days_left: '',
        }
        this.fetchData = this.fetchData.bind(this);
    }

    componentDidMount() {
        this.fetchData();
    }

    fetchData(){
        axios.get('/api/quotations/pending/'+this.props.id)
            .then((response) => {
                console.log('pending', response);
                this.setState({quotation: response.data.booking} );
                this.setState({time_left: response.data.time_left} );
                this.setState({days_left: response.data.days_left} );
            })
            .catch((error) => {
                this.props.history.push('quotations');
            });
    }

    render(){
        console.log('state', this.state)
        return (
            <>
            <Helmet> <title>Minibus - Pending Quotations</title> </Helmet>
            
            <section id="configuration" className="search view-cause  quatation-request">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                        <div className="card-content collapse show">
                            <div className="card-body table-responsive card-dashboard">
                            <div className="row ">
                                <div className="col-md-6">
                                    <h1 className="pull-left">Pending Quotation</h1>
                                </div>
                                <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                    <li className="breadcrumb-item"><Link to="/quotations">Quotations</Link></li>
                                    <li className="breadcrumb-item active"> Pending Quotation</li>
                                </ol>
                            </div>
                            </div>
                            <div className="row">
                                <div className="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                                <div className="box yellow w-100">
                                    <h2>Booking ID:</h2>
                                    <h3>{ this.state.quotation.id }</h3>
                                </div>
                                </div>
                                <div className="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                                <div className="box green w-100">
                                    <h2>Time left to trip:</h2>
                                    <h3>{ this.state.days_left }, { this.state.time_left } hours</h3>
                                </div>
                                </div>
                                <div className="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                                <div className="box red w-100">
                                    <h2>Booking Status:</h2>
                                    <h3>Receiving Quotations</h3>
                                </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-xl-6 col-12">
                                <div className="job-journey">
                                    <div className="row">
                                    <div className="col-12">
                                        <h2>Booking details</h2>
                                        <div className="step-main">
                                        <ul>
                                            <li className="">
                                            <div className="iccon "></div>
                                            <div className="step-box">
                                                <h3>Journey Summary</h3>
                                                <h6>Journey would be:</h6>
                                                <div className="row">
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-map-marker"></i>To: { this.state.quotation.dropoff_address }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-map-marker"></i>From: { this.state.quotation.pickup_address }</p>
                                                </div>
                                                </div>
                                                <p className="p1"><i className="fa fa-users"></i>With: { this.state.quotation.no_of_passengers } Passengers</p>
                                                <p className="p2">With: {(this.state.quotation.type== 1) ? 'Driver Only' : (this.state.quotation.type== 2) ? "Self" : "Both" }</p>
                                            </div>
                                            </li>
                                            <li className="">
                                            <div className="iccon"></div>
                                            <div className="step-box">
                                                <h3>Pick up Details</h3>
                                                <h6>Minibus will pick up on:</h6>
                                                <div className="row">
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-calendar"></i>{ this.state.quotation.pickup_date }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-clock-o"></i>{ this.state.quotation.pickup_time }</p>
                                                </div>
                                                </div>
                                            </div>
                                            </li>
                                            { this.state.is_return == 1 ? 
                                            <li className="">
                                            <div className="iccon"></div>
                                            <div className="step-box">
                                                <h3>Return Details</h3>
                                                <h6>Return will be on:</h6>
                                                <div className="row">
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-calendar"></i>{ this.state.quotation.return_date }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-clock-o"></i>{ this.state.quotation.return_time }</p>
                                                </div>
                                                <p className="p3"><i className="fa fa-map-marker"></i>Drop off at return: { this.state.quotation.return_address }</p>
                                                </div>
                                            </div>
                                            </li>
                                            : 
                                            "" }
                                            <li className="">
                                            <div className="iccon"></div>
                                            <div className="step-box">
                                                <h3>Additional Details</h3>
                                                <h6>Trip Reason: { this.state.quotation.trip_reason }</h6>
                                                <h6>You will have:</h6>
                                                <div className="row">
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-briefcase"></i>Hand Luggage: { this.state.quotation.hand_luggage }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-briefcase"></i>Medium luggage: { this.state.quotation.mid_luggage }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-briefcase"></i>large Luggage: { this.state.quotation.large_luggage }</p>
                                                </div>
                                                </div>
                                                <p className="p1">Additional Info: { this.state.quotation.additional_info }</p>
                                            </div>
                                            </li>
                                            <li className="">
                                            <div className="iccon"></div>
                                            <div className="step-box">
                                                <h3>Contact Details</h3>
                                                <div className="row">
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-user"></i>{ this.state.quotation.contact_name }</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <p> <i className="fa fa-briefcase"></i>{ this.state.quotation.contact_email }</p>
                                                </div>
                                                </div>
                                                <p className="p1"><i className="fa fa-phone"></i>{ this.state.quotation.contact_phone }</p>
                                            </div>
                                            </li>
                                        </ul>
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

export default withRouter(Pending);
