import React, {Component} from 'react';
import axios from 'axios';
import { useHistory, withRouter } from 'react-router-dom'

class View extends Component {

    constructor(props){
        super(props);
        this.state = {
            user: [],
            minibus: [],
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
                this.setState({minibus: response.data.minibus} );
            })
            .catch((error) => {
                this.props.history.push('/operators');
            });
    }

    render(){
        if(this.state.user) {
            return (
                <h1>view</h1>
            );
        }else{
            return ('');
        }
    }
}

export default withRouter(View);
