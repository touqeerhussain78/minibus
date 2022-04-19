import React, {Component} from 'react';
import { throws } from 'assert';

class Thumbnail extends Component {
    constructor(props){
        super(props);
        this.state = {
            media: this.props.data,
        }
        this.handleOnClick = this.handleOnClick.bind(this);
       
    }

    handleOnClick(id){
        document.getElementById('thumb'+id).outerHTML = '';
        this.props.callback(id);
    }

    render() {
        console.log('media', this.state.media, this.state.media.length);
        if(this.state.media.length){
            return (
                <div className="row">
                    {
                        this.state.media.map((item, index) => {
                            return (
                                <div id={"thumb"+item.id} key={index}  className="col-md-2">
                                    <img style={this.props.style}  src={item.path} />
                                    {  (this.props.edit) ? <a className="rm_thumb" onClick={ () => this.handleOnClick(item.id)} >Remove</a> : '' }
                                </div>
                            )
                        })
                    }
                </div>
            );
        }else { return ('') }
    }
}

export default Thumbnail;
