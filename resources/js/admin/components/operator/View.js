import React, {Component} from 'react';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import Thumbnail from "../Thumbnail";
import { Helmet } from 'react-helmet'

class View extends Component {

    constructor(props){
        super(props);
        this.state = {
            user: [],
            minibus: [],
            media: [],
            reviews: [],
        }
        this.fetchUser = this.fetchUser.bind(this);
    }

    componentDidMount() {
        this.fetchUser();
    }

    fetchUser(){
        axios.get('/api/operator/'+this.props.id)
            .then((response) => {
                this.setState({user: response.data.operator} );
                this.setState({minibus: response.data.minibus[0]} );
                this.setState({media: response.data.minibus[0].media} );
                this.setState({reviews: response.data.reviews} );
                console.log('minibus', response.data.minibus[0].model);
            })
            .catch((error) => {
                console.log(error);
               // this.props.history.push('/operators');
            });
    }

    render(){
        if(this.state.user) {
            return (
                <>
              <Helmet> <title>Minibus - Operator View</title> </Helmet>
              
                <section id="configuration" className="operator-detail search view-cause">
                    <div className="row">
                        <div className="col-12">
                            <div className="card rounded pad-20">
                                <div className="card-content collapse show">
                                    <div className="card-body table-responsive card-dashboard">
                                        <div className="row">
                                            <div className="col-md-6 col-12">
                                                <h1 className="pull-left">Operator Details</h1>
                                            </div>
                                            <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/operators">Operators</Link></li>
                                                <li className="breadcrumb-item active"> View</li>
                                            </ol>
                                        </div>
                                        </div>
                                        
                                        <div className="row">
                                            <div className="col-md-12">
                                                <div className="attached">
                                                    <img src={this.state.user.image} className="img-full" alt=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="row">
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-user-circle"/>Name</label>
                                                    <p>{this.state.user.name}</p>
                                                </div>
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-user-circle"/>Company Name</label>
                                                    <p>{this.state.user.company_name}</p>
                                                </div>

                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-envelope"/>Email</label>
                                                    <p>{this.state.user.email}</p>
                                                </div>
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-phone"/>mobile no</label>
                                                    <p>{this.state.user.phone_no}</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <label><i className="fa fa-map-marker"/>Address</label>
                                                    <p>{this.state.user.address}</p>
                                                </div>
                                                <div className="col-lg-6 col-12">
                                                    <label><i className="fa fa-map-marker"/>Country</label>
                                                    <p>{this.state.user.country}</p>
                                                </div>
                                                <div className="col-12">
                                                    <label><i className="fa fa-map-marker"/>City</label>
                                                    <p>{this.state.user.city}</p>
                                                </div>
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-map-marker"/>County</label>
                                                    <p>{this.state.user.state}</p>
                                                </div>
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-map-marker"/>Postal Code</label>
                                                    <p>{this.state.user.zipcode}</p>
                                                </div>
                                                <div className="col-md-6 col-12">
                                                    <label><i className="fa fa-address-card"/>Operator Licence Number</label>
                                                    <p>{this.state.user.drivers_license}</p>
                                                </div>
                                            </div> 
                                            <div className="operator-bus-detail">
                                                <div className="top">
                                                <div className="row">
                                                <div className="upload-holder-previews form-group col-xl-12 col-12">
                                                {
                                                    (this.state.media.length) ?
                                                    <div className="row">
                                                    {
                                                        this.state.media.map((item, index) => {
                                                            return (
                                                                <div id={"thumb"+item.id} key={index}  className="col-md-6">
                                                                    <img style={this.props.style}  src={item.path} />
                                                                </div>
                                                            )
                                                        })
                                                    }
                                                </div>
                                                        : ''
                                                }
                                          
                                                    

                                            </div>
                                                </div>
                                                    </div>
                                                <div className="middle">
                                                <div className="row">
                                                <div className="col-xl-6 col-12">
                                                    <h2>Further Information</h2>
                                                    <p className="border-0">{this.state.user.aboutme}</p>
                                                </div>
                                                <div className="col-xl-6 col-12">
                                                    <h2>Minibus Type</h2>
                                                    <h3>Model: <span>{this.state.minibus.model}</span></h3>
                                                    <h4>Capacity: <span>{this.state.minibus.capacity}</span></h4>
                                                    <p>{this.state.minibus.description}</p>
                                                </div>
                                                </div>
                                                </div>
                                                {this.state.reviews.length>0 ?
                                                <div className="bottom">
                                                <div className="row">
                                                <div className="col-12">
                                                    <h2>Reviews</h2>
                                                </div>
                                                </div>
                                               
                                                <div className="row">
                                                {this.state.reviews.length>0 && this.state.reviews.map(row => 
                                                    <div className="col-md-6 col-12">
                                                    <div className="box">
                                                    <div className="media"> <img src={row.user.image ? row.user.image : window.base_url + '/administrator/images/Profile_03.png'} alt="user image"  className="img-fluid"/>
                                                        <div className="media-body">
                                                        <p>{row.comments}</p>
                                                        <h5>{row.user.name}</h5>
                                                       
                                                        </div>
                                                    </div>
                                                    </div> 
                                                </div>
                                                )}
                                                </div>

                                                </div>
                                                : ""
                                                }
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
        }else{
            return ('');
        }
    }
}

export default withRouter(View);
