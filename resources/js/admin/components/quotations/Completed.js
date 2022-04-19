import React, {Component} from 'react';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import { Helmet } from 'react-helmet'
import dateFormat from 'dateformat';

class Completed extends Component {

    constructor(props){
        super(props);
        this.state = {
            quotation: [],
            quote: '',
            operator: '',
            minibus: '',
            media: [],
        }
        this.fetchData = this.fetchData.bind(this);
    }

    componentDidMount() {
        this.fetchData();
    }

    fetchData(){
        axios.get('/api/quotations/completed/'+this.props.id)
            .then((response) => {
                
                this.setState({quote: response.data.quote} );
                this.setState({quotation: response.data.quote.booking} );
                this.setState({operator: response.data.quote.operator} );
                this.setState({security_deposit: response.data.security_deposit} );
                this.setState({amount_remaining: response.data.amount_remaining} );
                this.setState({minibus: response.data.quote.operator.minibus[0]} );
                this.setState({media: response.data.quote.operator.minibus[0].media} );
                console.log('minibus', this.state.minibus);
            })
            .catch((error) => {
                this.props.history.push('quotations');
            });
    }

    render(){
        return (
            <>
            <Helmet> <title>Minibus - Completed Quotations</title> </Helmet>
            
            <section id="configuration" className="search view-cause quatation-request q-accept">
                <div className="row">
                <div className="col-12">
                    <div className="card rounded pad-20">
                    <div className="card-content collapse show">
                        <div className="card-body table-responsive card-dashboard">
                        <div className="row ">
                            <div className="col-md-6">
                            <h1 className="pull-left">Quotations Completed</h1>
                            </div>
                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                    <li className="breadcrumb-item"><Link to="/quotations">Quotations</Link></li>
                                    <li className="breadcrumb-item active"> Completed Quotation</li>
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
                                <h2>Trip Started on:</h2>
                                <h3>{ this.state.quotation.pickup_date }</h3>
                            </div>
                            </div>
                            <div className="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                            <div className="box dark-green w-100">
                                <h2>Trip Completed on:</h2>
                                <h3>{dateFormat(this.state.quotation.trip_end_date, "dd-mm-yyyy")  }</h3>
                            </div>
                            </div> 
                            <div className="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                            <div className="box red w-100">
                                <h2>Booking Status:</h2>
                                <h3>Trip Completed</h3>
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
                                            <h6>Trip Reason: Business</h6>
                                            <h6>You will have:</h6>
                                            <div className="row">
                                            <div className="col-lg-6 col-12">
                                                <p> <i className="fa fa-briefcase"></i>large Luggage: { this.state.quotation.hand_luggage }</p>
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
                            <div className="col-xl-6 col-12">
                                <h2>Quotations received</h2>
                                <div className="qutation-right q-acc-right">
                                    
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="box">
                                            <div className="top text-center"> 
                                            <h6>Payment Status: Total Amount Paid</h6>
                                            <h5>Operator for this trip</h5>
                                            <img src={ this.state.operator.image} className="img-fluid" alt="" /> 
                                                <h3>{ this.state.operator.name}</h3>
                                                <h4>{ this.state.operator.company_name}</h4>
                                                <a onClick={ () => this.props.history.push('/operators/view/'+this.state.operator.id)} className="pur-btn"> View Profile</a>
                                                <p><i className="fa fa-money"></i>Trip Amount: <b>£{ this.state.quote.amount ? this.state.quote.amount : 0}</b></p>
                                            </div> 
                                            <div className="bottom">
                                            <div className="row">
                                            {
                                                this.state.media.map((img, i) => {
                                                return (
                                                <div className="col-lg-4 col-sm-6 col-12">
                                                    <img src={img.path} className="img-fluid" alt="" />
                                                </div>
                                                ) 
                                                })
                                            }
                                            </div>
                                            <h2>Minibus Type</h2> 
                                                <div className="row">
                                                    <div className="col-lg-6 col-12 pr-lg-0"><p>Model: <span>{ this.state.minibus.model }</span></p></div>
                                                    <div className="col-lg-6 col-12 pl-lg-0"><p>Capacity: <span>{ this.state.minibus.capacity }</span></p></div>
                                                </div> 
                                                <h2>about the operator:</h2> 
                                                <p>{ this.state.operator.aboutme }</p>
                                                
                                                <h2>Minibus Description:</h2> 
                                                <p>{ this.state.minibus.description }</p>
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
                </div>
            </section>
       </>
       );
    }
}

export default withRouter(Completed);
