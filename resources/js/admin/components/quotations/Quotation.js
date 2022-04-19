import React, {Component} from 'react';
import { Link } from 'react-router-dom';
import Listing from "./Listing";
import Pending from "./Pending";
import Accepted from "./Accepted";
import Confirmed from "./Confirmed";
import Completed from "./Completed";
import Cancelled from "./Cancelled";
import User from "./User";
import Operator from "./Operator";
import Stats from "./Stats";


class Quotation extends Component {
    constructor(props){
        super(props);
    }

    render(){
        const { pathParam1, pathParam2 } = this.props.match.params;
        if( pathParam1 == undefined && pathParam2 == undefined)
          return (<Listing></Listing>)
        else if(pathParam1 == "pending" && pathParam2 !== undefined){
            return (<Pending id={pathParam2}></Pending>)
        }
        else if(pathParam1 == "accepted" && pathParam2 !== undefined){
            return (<Accepted id={pathParam2}></Accepted>)
        }
        else if(pathParam1 == "confirmed" && pathParam2 !== undefined){
            return (<Confirmed id={pathParam2}></Confirmed>)
        }
        else if(pathParam1 == "completed" && pathParam2 !== undefined){
            return (<Completed id={pathParam2}></Completed>)
        }
        else if(pathParam1 == "cancelled" && pathParam2 !== undefined){
            return (<Cancelled id={pathParam2}></Cancelled>)
        }
        else if(pathParam1 == "stats"){
            return (<Stats></Stats>)
        }
        else if(pathParam1 == "user" && pathParam2 !== undefined){
            return (<User id={pathParam2}></User>)
        }
        else if(pathParam1 == "operator" && pathParam2 !== undefined){
            return (<Operator id={pathParam2}></Operator>)
        }
        else
        return (<Listing></Listing>)

    }
}

export default Quotation;
