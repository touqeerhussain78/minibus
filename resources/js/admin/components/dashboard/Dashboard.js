import React, {Component} from 'react';
import { Link } from 'react-router-dom'
import axios from "axios";
import toastr from "toastr";
import $ from "jquery";
import { Helmet } from 'react-helmet'


class Dashboard extends Component {

    constructor(props){
        super(props);
        this.state = {
            stats: {},
        }
    }

    componentDidMount() {
        this.fetchDashboard();
    }

    fetchDashboard = () => {
        axios.get('api/dashboard-stats')
            .then((response) => {
                this.setState({ stats: response.data });
            })
            .catch((error) => {
                console.log(error);
            });
    }

     kFormatter = (num) => {
        return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K' : Math.sign(num)*Math.abs(num)
    }

    render(){
        return (
            <>
            <Helmet> <title>Minibus - Dashboard</title> </Helmet>
            
            <section id="combination-charts" className=" operator dashboard">
                <div className="row">
                    <div className="col-12">
                        <div className="row">
                            <div className="col-lg-4 col-sm-6 col-12 d-flex">
                                <div className="box-main flex-column">
                                    <div className="box box-1 ">
                                        <div className="img-div" />
                                        <h2>{ this.kFormatter(this.state.stats.users) } Users</h2>
                                        
                                        <Link to="users"> view all <i className="fa fa-angle-right p-left-arrow" aria-hidden="true" /> </Link>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-sm-6 col-12 d-flex">
                                <div className="box-main flex-column">
                                    <div className="box box-2  ">
                                        <div className="img-div" />
                                        <h2>{ this.kFormatter(this.state.stats.operators) } Operators</h2>
                                        <Link to="operators"> view all <i className="fa fa-angle-right p-left-arrow" aria-hidden="true" /> </Link>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-sm-6 col-12 d-flex">
                                <div className="box-main flex-column">
                                    <div className="box box-3">
                                        <div className="img-div" />
                                        <h2>{ this.kFormatter(this.state.stats.bookings) } Completed Quotations</h2>
                                        <Link to="quotations"> view all  <i className="fa fa-angle-right p-left-arrow" aria-hidden="true" /></Link>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-sm-6 col-12 d-flex">
                                <div className="box-main flex-column">
                                    <div className="box box-4 ">
                                        <div className="img-div" />
                                        <h2>{ this.kFormatter(this.state.stats.feedbacks) } Feedbacks</h2>
                                        <Link to="feedbacks"> view all <i className="fa fa-angle-right p-left-arrow" aria-hidden="true" /> </Link>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-sm-6 col-12 d-flex">
                                <div className="box-main flex-column">
                                    <div className="box box-6 ">
                                        <div className="img-div" />
                                        <h2>{ this.kFormatter(this.state.stats.payments) } Payments</h2>
                                        <Link to="payments"> view Details <i className="fa fa-angle-right p-left-arrow" aria-hidden="true" /> </Link>
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

export default Dashboard;
