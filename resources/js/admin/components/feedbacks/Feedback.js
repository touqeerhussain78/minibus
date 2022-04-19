import React, {Component} from 'react';
import { Link } from 'react-router-dom';
import Listing from "./Listing";
import View from "./View";
import Reports from "./Reports";
import ReportView from "./ReportView";

class Feedback extends Component {
    render(){
        const { pathParam1, pathParam2 } = this.props.match.params;
        
        if( pathParam1 == undefined && pathParam2 == undefined)
          return (<Listing></Listing>)
        else if(pathParam1 == "view" && pathParam2 !== undefined){
            return (<View id={pathParam2}></View>)
        } 
        else if(pathParam1 == "reports" )
            return (<Reports></Reports>) 
        else if(pathParam1 == "report-view"  && pathParam2 !== undefined)
            return (<ReportView id={pathParam2}></ReportView>) 
        else
          return (<Listing></Listing>)
    }
}

export default Feedback;
