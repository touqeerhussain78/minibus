import React, {Component} from 'react';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    History,
    Link,
    NavLink,
    useRouteMatch
} from "react-router-dom";


function CustomLi({ label, to, activeOnlyWhenExact,icon }) {
    let match = useRouteMatch({
      path: to,
      exact: activeOnlyWhenExact
    });
  
    return (
        <li className={match ? "active" : ""}>
            <Link className='nav-item' to={to}>
                <i className={`fa ${icon}`} /><span className="menu-title">{label}</span>
            </Link>
        </li>
    );
  }

class Navbar extends Component {
    render(){
        return (
            <div className="main-menu menu-fixed menu-light menu-accordion" data-scroll-to-active="true">
                <div className="main-menu-content ps-container ps-theme-dark" data-ps-id="fe0d58f4-e648-c522-0bbb-eb0f56366e09">
                    <ul className="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <CustomLi activeOnlyWhenExact={true} to="/dashboard" label="Dashboard" icon="fa-home" />
                        <CustomLi activeOnlyWhenExact={true} to="/operators" label="Operators" icon="fa-users" />
                        <CustomLi activeOnlyWhenExact={true} to="/users" label="Users" icon="fa-user" />
                        <CustomLi activeOnlyWhenExact={true} to="/quotations" label="Quotations" icon="fa-file-text-o" />
                        <CustomLi activeOnlyWhenExact={true} to="/payments" label="Payments" icon="fa-money" />
                        <CustomLi activeOnlyWhenExact={true} to="/feedbacks" label="Feedbacks" icon="fa-comments" />
                    </ul>
            </div>
            </div>
        );
    }
}



export default Navbar;
