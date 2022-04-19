import React, {Component} from 'react';
import Listing from "./Listing";
import Blocked from "./Blocked";
import Add from "./Add";
import Edit from "./Edit";
import View from "./View";

class User extends Component {

    constructor(props){
        super(props);
    }

    render(){
      const { pathParam1, pathParam2 } = this.props.match.params;
      if( pathParam1 == undefined && pathParam2 == undefined)
          return (<Listing blocked={false}></Listing>)
      else if(pathParam1 == "add"){
          return (<Add></Add>)
      }
      else if(pathParam1 == "blocked"){
          return (<Blocked blocked={false}></Blocked>)
      }
      else if(pathParam1 == "edit" && pathParam2 !== undefined){
          return (<Edit id={pathParam2}></Edit>)
      }
      else if(pathParam1 == "view" && pathParam2 !== undefined){
          return (<View id={pathParam2}></View>)
      }
      else
          return (<Listing></Listing>)

    }
}

export default User;
