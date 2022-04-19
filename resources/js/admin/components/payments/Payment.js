import React, {Component} from 'react';
import { Link } from 'react-router-dom';
import Listing from "./Listing";
import Package from "./Package";
import MyPayment from "./MyPayment";
import View from "./Completed";
import UserView from "./Completed";

class Payment extends Component {
    render(){
        const { pathParam1, pathParam2 } = this.props.match.params;
        console.log('pathParam1', pathParam1);
        console.log('pathParam2', pathParam2);
        if( pathParam1 == undefined && pathParam2 == undefined)
          return (<Listing></Listing>)
          
        else if(pathParam1 == "view" && pathParam2 !== undefined){
            return (<View id={pathParam2}></View>)
        }

        else if(pathParam1 == "view-user" && pathParam2 !== undefined){
            return (<UserView id={pathParam2}></UserView>)
        }
        
        else if(pathParam1 == "package" )
           return (<Package></Package>)
        else if( pathParam1 == "mypayments")
            return (<MyPayment></MyPayment>)
        else
            return (<Listing></Listing>)
    }
}

export default Payment;
