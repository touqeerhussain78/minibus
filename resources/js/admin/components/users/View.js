import React, {Component} from 'react';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import { Helmet } from 'react-helmet'

class View extends Component {

    constructor(props){
        super(props);
        this.state = {
            user: [],
        }
        this.fetchUser = this.fetchUser.bind(this);
    }

    componentDidMount() {
        this.fetchUser();
    }

    fetchUser(){
        axios.get('/api/users/'+this.props.id)
            .then((response) => {
                this.setState({user: response.data} );
            })
            .catch((error) => {
                this.props.history.push('users');
            });
    }

    render(){
        return (
            <>
            <Helmet> <title>Minibus - View User</title> </Helmet>
            
            <section id="configuration" className="operator-detail search view-cause">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-md-6 col-12">
                                            <h1 className="pull-left">user Details</h1>
                                        </div>
                                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/users">Users</Link></li>
                                                <li className="breadcrumb-item active"> View</li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-12">
                                            <div className="attached">
                                                <img src={this.state.user.image ? this.state.user.image : window.base_url + '/administrator/images/Profile_03.png'} className="img-full" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-user-circle"/>username</label>
                                            <p>{this.state.user.surname}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-user-circle"/>Name</label>
                                            <p>{this.state.user.name}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-envelope"/>Email</label>
                                            <p>{this.state.user.email}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-phone"/>mobile no</label>
                                            <p>{this.state.user.phone_no}</p>
                                        </div>
                                        <div className="col-lg-6 col-12">
                                            <label htmlFor><i className="fa fa-map-marker"/>Address</label>
                                            <p>{this.state.user.address}</p>
                                        </div>
                                        <div className="col-lg-6 col-12">
                                            <label htmlFor><i className="fa fa-map-marker"/>Country</label>
                                            <p>{this.state.user.country}</p>
                                        </div>
                                        <div className="col-12">
                                            <label htmlFor><i className="fa fa-map-marker"/>City</label>
                                            <p>{this.state.user.city}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-map-marker"/>County</label>
                                            <p>{this.state.user.state}</p>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <label htmlFor><i className="fa fa-map-marker"/>Zip Code</label>
                                            <p>{this.state.user.zipcode}</p>
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

export default withRouter(View);
