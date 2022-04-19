import React, {Component} from 'react';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import { Helmet } from 'react-helmet'

class View extends Component {

    constructor(props){
        super(props);
        this.state = {
            feedback: "",
            user: ''
        }
        this.fetchFeedback = this.fetchFeedback.bind(this);
    }

    componentDidMount() {
        this.fetchFeedback();
    }

    fetchFeedback(){
        axios.get('/api/feedbacks/view/'+this.props.id)
            .then((response) => {
                this.setState({feedback: response.data.feedback} );
                this.setState({user: response.data.feedback.user} );
              
            })
            .catch((error) => {
                console.log(error);
            });
    }

    render(){
       console.log(this.state.user); 
       
        if(this.state.feedback) {
            return (
              <>
              <Helmet> <title>Minibus - Feedback View</title> </Helmet>
              
                <section id="configuration" className="u-c-p u-profile a-feedback">
                <div className="row">
                    <div className="col-12 pad-20"> 
                      <div className="row">
                        <div className="col-md-6 col-12">
                          <h1 className="pull-left">Feedback detail</h1>
                        </div>
                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/feedbacks">feedbacks</Link></li>
                                                <li className="breadcrumb-item active"> View</li>
                                            </ol>
                                        </div>
                      </div>
                  <div className="row">
                    <div className="col-7">
                         <div className="profile-frm">
                          <div className="card pro-main">
                            <div className="row">
                              <div className="col-12">
                                <img src={this.state.user ? (this.state.user.image!==null ? this.state.user.image :window.base_url + '/administrator/images/Profile_03.png' ) : window.base_url + '/administrator/images/Profile_03.png'} className="img-fluid" alt="" />
                                <div className="row">
                                  <div className=" col-12">
                                      <div className="d-flex justify-content-between">
                                          <div className="">
                                          <label><i className="fa fa-user-circle"></i> User</label>
                                          <p>{this.state.user ? this.state.user.name : "Guest User"}</p>
                                                    </div>
                                                <div className="">
                                                {/* <a href="#" className="delete"><i className="fa fa-trash"></i>delete</a> */}
                                                </div>
                                                </div>
                                          <label><i className="fa fa-file"></i>subject</label>
                                          <p>{this.state.feedback.subject}</p> 
                                                      <label><i className="fa fa-calendar"></i>Date</label>
                                          <p>{this.state.feedback.created_at}</p>
                                          <label><i className="fa fa-comments"></i> message</label>
                                          <p>{this.state.feedback.message}</p>
                                            {/* <a href="a-feedback.html" className="yel-btn">Back</a> */}
                                  </div>
                                  <br />
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
        }else{
            return ('');
        }
    }
}

export default withRouter(View);
