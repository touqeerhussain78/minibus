import React, { Component } from "react";
import { Link, useHistory, withRouter, useParams } from "react-router-dom";
import toastr from 'toastr';

class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            notification:[]
        }
        this.fetchNotifications = this.fetchNotifications.bind(this);
        this.readall = this.readall.bind(this);
        this.read = this.read.bind(this);
    }

    componentDidMount() {
        this.fetchNotifications();
    }

    handleMenuToggle = () => {
        var el = document.querySelector("body");
        el.classList.toggle('menu-open');
        el.classList.toggle('menu-hide');
    };

    handleFullScreenMenuToggle = () => {
        var el = document.querySelector("body");
        el.classList.toggle('menu-expanded');
        el.classList.toggle('menu-collapsed');

    }

    fetchNotifications(){
        var url = 'api/unreadNotifications';
        axios.get(url)
            .then((response) => {
                this.setState({ notification: response.data.data});
                console.log('notification', this.state.notification);
            })
            .catch((error) => {
                console.log(error);
            });
    }

     kFormatter = (num) => {
        return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
    }

    readall() {
        var url = 'api/markasread';
        axios.get(url)
            .then((response) => {
                console.log('response', response);
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                    window.location.reload();
                }, 700);
            })
            .catch((error) => {
                console.log(error);
            });
      }

      read(id) {
       //   console.log(id); return;
        var url = 'api/markasread/'+id;
        axios.get(url)
            .then((response) => {
                console.log('response', response.data.url);
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                    window.location.href = window.base_url+'/admin/'+response.data.url;
                }, 1000);
            })
            .catch((error) => {
                console.log(error);
            });
      }
    

    render() {
        return (
            <nav className="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-border">
                <div className="navbar-wrapper">
                    <div className="navbar-header">
                        <ul className="nav navbar-nav flex-row">
                            <li className="nav-item mobile-menu d-md-none mr-auto">
                                <a
                                    onClick={this.handleMenuToggle}
                                    className="nav-link nav-menu-main menu-toggle hidden-xs is-active"
                                    href="#"
                                >
                                    <i className="fa fa-bars" />
                                </a>
                            </li>
                            <li className="nav-item">
                                {" "}
                                <a className="navbar-brand" href={window.base_url+'/admin' }>
                                    <img
                                        className="brand-logo"
                                        alt="stack admin logo"
                                        src={this.props.asset_url +"images/logo.png"
                                        }
                                    />{" "}
                                </a>{" "}
                            </li>
                            <li className="nav-item d-md-none">
                                {" "}
                                <a
                                    className="nav-link open-navbar-container"
                                    data-toggle="collapse"
                                    data-target="#navbar-mobile"
                                >
                                    <i className="fa fa-ellipsis-v" />
                                </a>{" "}
                            </li>
                        </ul>
                    </div>
                    <div className="navbar-container content">
                        <div
                            className="collapse navbar-collapse"
                            id="navbar-mobile"
                        >
                            <ul className="nav navbar-nav mr-auto float-left"></ul>
                            <ul className="nav navbar-nav float-right">
                                <li className="dropdown dropdown-notification nav-item">
                                    <a
                                        className="nav-link nav-link-label"
                                        href="#"
                                        data-toggle="dropdown"
                                    >
                                        <i className="fa fa-bell" />
                                        <span className="badge badge-pill badge-default badge-danger badge-default badge-up">
                                            { this.kFormatter(this.state.notification.length) }
                                        </span>
                                    </a>
                                    <ul className="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                        <li className="dropdown-menu-header">
                                            <h6 className="dropdown-header m-0">
                                                <span className="grey darken-2">
                                                    Notifications
                                                </span>
                                                <span className="notification-tag badge badge-default badge-danger float-right m-0">
                                                { this.kFormatter(this.state.notification.length) } New
                                                </span>
                                            </h6>
                                        </li>
                                        <li
                                            className="scrollable-container media-list ps-container ps-theme-dark ps-active-y"
                                            data-ps-id="66eb83f7-a3af-e812-7d0d-471e454e7e2f"
                                        >
                                            
                  
                                     {this.state.notification.map((notification, i) => {         
                                            return (
                                            <a onClick={() => this.read(notification.id)}>
                                            <div className="media">
                                                <div className="media-left align-self-center">
                                                    <i className="fa fa-plus-square-o" />
                                                </div>
                                                <div className="media-body">
                                                    <p className="notification-text font-small-3 text-muted">
                                                    {notification.data.message}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                       ) 
                                        })} 
                                            
                                            <div
                                                className="ps-scrollbar-x-rail"
                                                style={{
                                                    left: "0px",
                                                    bottom: "3px"
                                                }}
                                            > 
                                                <div
                                                    className="ps-scrollbar-x"
                                                    tabIndex={0}
                                                    style={{
                                                        left: "0px",
                                                        width: "0px"
                                                    }}
                                                />
                                            </div>
                                            
                                        </li>
                                        {/* <li className="dropdown-menu-footer">
                                            <a
                                                className="dropdown-item text-muted text-center"
                                                onClick={() => this.readall()}
                                            >
                                                Read all notifications
                                            </a>
                                        </li> */}
                                    </ul>
                                </li>
                                <li className="dropdown dropdown-user nav-item">
                                    {" "}
                                    <a
                                        className="dropdown-toggle nav-link dropdown-user-link"
                                        href="#"
                                        data-toggle="dropdown"
                                    >
                                        <span className="avatar avatar-online">
                                            <img
                                                src={window.user.image ? window.user.image :  window.base_url + '/administrator/images/Profile_03.png'}
                                                alt="avatar"
                                            />
                                            <i />
                                        </span>
                                        <span className="user-name">
                                            {window.user.name}
                                        </span>{" "}
                                    </a>
                                    <div className="dropdown-menu dropdown-menu-right">
                                        <Link
                                            className="dropdown-item"
                                            to="/profile"
                                        >
                                            <i className="fa fa-user" />
                                            Profile
                                        </Link>
                                        <div className="dropdown-divider" />
                                        <a
                                            className="dropdown-item"
                                            href={
                                                window.base_url +
                                                "/admin/logout"
                                            }
                                        >
                                            <i className="fa fa-power-off" />{""}logout
                                        </a>{" "}
                                    </div>
                                </li>
                                <li className="nav-item d-none d-md-block">
                                    <a
                                        onClick={this.handleFullScreenMenuToggle}
                                        className="nav-link nav-menu-main menu-toggle hidden-xs is-active"
                                        href="#"
                                    >
                                        <i className="fa fa-bars" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        );
    }
}

export default Header;
