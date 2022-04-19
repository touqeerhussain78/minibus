import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import Header from './common/Header'
import Navbar from './common/Navbar'
import Dashboard from "./dashboard/Dashboard";
import Operator from "./operator/Operator";
import User from "./users/User";
import Quotation from "./quotations/Quotation";
import Payment from "./payments/Payment";
import Feedback from "./feedbacks/Feedback";
import Profile from "./common/Profile";
import EditProfile from "./common/EditProfile";
import UserView from "./payments/Completed";

class App extends Component {


    render () {

        //let base = `${process.env.NODE_ENV === 'production' ? process.env.MIX_PRODUCTION_BASE_URL: process.env.MIX_BASE_URL}/admin`;
        let base =  window.base_url.replace((window.location.protocol + '//' + window.location.host), '') + `/admin`;
        return (
            <BrowserRouter basename={base}>
                    <Header base_url={window.base_url}  asset_url={window.asset_url}/>
                    <Navbar base_url={window.base_url}  asset_url={window.asset_url} />
                    <Switch>
                        <div className="app-content content">
                            <div className="content-wrapper">
                                <div className="content-body">
                                    <Switch>
                                        <React.Fragment>
                                            <Route exact  className="active" path="/" component={Dashboard} />
                                            <Route exact  className="active" path="/dashboard" component={Dashboard} />
                                            <Route exact  className="active" path="/profile" component={Profile} />
                                            <Route exact  className="active" path="/edit-profile" component={EditProfile} />
                                            <Route exact  className="active" path="/operators/:pathParam1?/:pathParam2?"  component={Operator} />
                                            <Route exact  className="active" path="/users/:pathParam1?/:pathParam2?"  component={User} />
                                            <Route exact  className="active" path="/quotations/:pathParam1?/:pathParam2?" component={Quotation} />
                                            <Route exact  className="active" path="/payments/:pathParam1?/:pathParam2?" component={Payment} />
                                         
                                            <Route exact  className="active" path="/feedbacks/:pathParam1?/:pathParam2?" component={Feedback} />
                                        </React.Fragment>
                                    </Switch>
                              </div>
                            </div>
                        </div>
                    </Switch>
            </BrowserRouter>
        )
    }
}

ReactDOM.render(<App />, document.getElementById('app'))
