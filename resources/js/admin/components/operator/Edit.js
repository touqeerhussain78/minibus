import React, {Component} from 'react';
import PlacesAutocomplete, {
    geocodeByAddress,
    getLatLng,
} from 'react-places-autocomplete';
import Form from 'react-validation/build/form';
import Input from 'react-validation/build/input';
import Button from 'react-validation/build/button';
import toastr from 'toastr';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom'
import Cropper from 'react-cropper';
import 'cropperjs/dist/cropper.css';
import { isEmail } from 'validator';
import $ from 'jquery';
import ImageUploader from '../ImageUploader';
import Thumbnail from "../Thumbnail";
import { Helmet } from 'react-helmet'

const required = (value, props) => {
    if (!value || (props.isCheckable && !props.checked)) {
        return <span className="form-error is-visible">The Field is Required</span>;
    }
};

const email = (value) => {
    if (!isEmail(value)) {
        return <span className="form-error is-visible">${value} is not a valid email.</span>;
    }
};

const isEqual = (value, props, components) => {
    const bothUsed = components.password[0].isUsed && components.confirm[0].isUsed;
    const bothChanged = components.password[0].isChanged && components.confirm[0].isChanged;

    if (bothChanged && bothUsed && components.password[0].value !== components.confirm[0].value) {
        return <span className="form-error is-visible">Passwords are not equal.</span>;
    }
};

const cropper = React.createRef(null);

class Edit extends Component {

    constructor(props){
        super(props);
        this.state = {
            minibus: '',
            user: '',
            address: '',
            activeFile: '',
            image: '',
            cropResult: window.base_url + '/administrator/images/Profile_03.png',
        }
        this.thumbs = [];
        this.ThumbCallback = this.ThumbCallback.bind(this);
        this.fetchOperator = this.fetchOperator.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleFileChange = this.handleFileChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.cropImage = this.cropImage.bind(this);
    }

    componentDidMount(){
        this.fetchOperator();
    }

    ThumbCallback(item){
        if(item)
            this.thumbs.push(item);
        console.log(this.thumbs);
        console.log(item);
    }

    fetchOperator(){
        axios.get('/api/operator/'+this.props.id)
            .then((response) => {
                this.setState({user: response.data.operator} );
                this.setState({minibus: response.data.minibus} );
                if(response.data.operator.image){
                    this.setState({ cropResult: response.data.operator.image});
                }
                document.getElementsByName('type')[response.data.minibus[0].type].checked = true
            })
            .catch((error) => {
               // this.props.history.push('/users');
            });
    }

    handleSubmit(event){
        event.preventDefault();
        console.log('image',this.state.image);
    
        const data = new FormData(event.target);
        var thumbs = (this.thumbs.length) ? this.thumbs : [];
        console.log(thumbs);
        for (var i = 0; i < this.thumbs.length; i++) {
            data.append('thumbs[]', this.thumbs[i]);
        }
        data.append('image', this.state.image);
        data.append('id', this.props.id);
        axios.post('/api/operator/update', data)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                // setTimeout(()=> {
                //     this.props.history.push('/operators');
                // }, 700);
            })
            .catch((error) => {
                let e = error.response;
                let errors = e.data.errors;
                Object.keys(errors).forEach(key=>{
                    toastr.error(errors[key], "Error!");
                });
                setTimeout(()=> {
                    document.body.classList.remove('loading-indicator');
                }, 1000);
            });
    }

    handleChange(address){
        this.setState({ address: address });
    };

    handleSelect(address){
        this.setState({ address: address });
        geocodeByAddress(address)
            .then(function(result){
                var componentForm = {
                    locality: 'long_name',
                    administrative_area_level_1: 'short_name',
                    country: 'long_name',
                    postal_code: 'short_name'
                };

                for (var i = 0; i < result[0].address_components.length; i++) {
                    var addressType = result[0].address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = result[0].address_components[i][componentForm[addressType]];
                        if(val){
                            console.log(addressType , val);
                            document.getElementById(addressType).value = val;
                        }
                   }
                }

                console.log(result)

            })
    };

    handleFileChange(event){
        var size = event.target.files[0].size;
        if(size <= 5087353){
            $('#cropImagePop').modal('toggle');
            this.setState({ activeFile: URL.createObjectURL(event.target.files[0])});
            this.setState({ image: event.target.files[0] });
        }else{
            toastr.error('File size is too big, Maximum 5MB allowed','Error');
        }
    }

    cropImage(){
        if (typeof this.cropper.getCroppedCanvas() === 'undefined') {
            return;
        }
        this.setState({
            cropResult: this.cropper.getCroppedCanvas().toDataURL(),
        });
    }

    render(){
        if(!this.state.user) { return ('') } else {
        return (
            <>
              <Helmet> <title>Minibus - Edit Operator</title> </Helmet>
              
            <section id="configuration" className="search view-cause add-operator-details">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-sm-6 col-12">
                                            <h1 className="pull-left">Edit Operator</h1>
                                        </div>
                                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/operators">Operators</Link></li>
                                                <li className="breadcrumb-item active"> Edit</li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="add-detail">
                                                <Form ref={c => { this.form = c }} onSubmit={this.handleSubmit}>

                                                    <div className="row">
                                                        <div className="col-md-12">
                                                            <div className="attached">

                                                                <img src={this.state.cropResult}
                                                                     className="img-full" alt="" ></img>
                                                                    <button name="file" type="button" className="change-cover"
                                                                        onClick={(e) => this.fileElement.click()}>
                                                                    <div className="ca"><i className="fa fa-camera"></i>
                                                                    </div>
                                                                </button>
                                                                <input style={{display:'none'}}
                                                                       onChange={ (event) => this.handleFileChange(event) }
                                                                       ref={input => this.fileElement = input}
                                                                       accept={'image/*'}
                                                                       type="file" name="picture" />
                                                                <input type="hidden" name="image" id="image" value={this.state.cropResult}/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-user-circle" />
                                                            <Input value={this.state.user.name} type="text" id="name" name="name" className="form-control" spellCheck="true" placeholder="Name" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-user-circle" />
                                                            <Input value={this.state.user.company_name} type="text" id="company_name" name="company_name" className="form-control" spellCheck="true" placeholder="Company Name" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-envelope" />
                                                            <Input type="email" value={this.state.user.email} disabled id="email" name="email" className="form-control" spellCheck="true" placeholder="Email" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-phone" />
                                                            <Input type="number" id="phone-2" value={this.state.user.phone_no} id="phone_no" name="phone_no" className="form-control" spellCheck="true" placeholder="Phone" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <PlacesAutocomplete
                                                            value={(this.state.address) ? this.state.address : this.state.user.address }
                                                            onChange={this.handleChange}
                                                            onSelect={this.handleSelect}
                                                        >
                                                            {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                                                                <div className="col-md-12 form-group">
                                                                    <i className="fa fa-map-marker" />
                                                                    <input
                                                                        {...getInputProps({
                                                                            id: 'address',
                                                                            name: 'address',
                                                                            placeholder: 'Address',
                                                                            className: 'form-control location-search-input',
                                                                        })}

                                                                    />
                                                                    <div className="autocomplete-dropdown-container">
                                                                        {loading && <div>Loading...</div>}
                                                                        {suggestions.map(suggestion => {
                                                                            const className = suggestion.active
                                                                                ? 'suggestion-item--active'
                                                                                : 'suggestion-item';
                                                                            // inline style for demonstration purpose
                                                                            const style = suggestion.active
                                                                                ? { backgroundColor: '#fafafa', cursor: 'pointer' }
                                                                                : { backgroundColor: '#ffffff', cursor: 'pointer' };
                                                                            return (
                                                                                <div
                                                                                    {...getSuggestionItemProps(suggestion, {
                                                                                        className,
                                                                                        style,
                                                                                    })}
                                                                                >
                                                                                    <span>{suggestion.description}</span>
                                                                                </div>
                                                                            );
                                                                        })}
                                                                    </div>
                                                                </div>
                                                            )}
                                                        </PlacesAutocomplete>
                                                    </div>

                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input value={this.state.user.country} type="text" id="country" name="country" className="form-control" spellCheck="true" placeholder="Country" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input value={this.state.user.city} type="text" id="locality" name="city" className="form-control" spellCheck="true" placeholder="City" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input type="text" id="postal_code" value={this.state.user.zipcode} name="zipcode" className="form-control" spellCheck="true" placeholder="Postal Code" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input value={this.state.user.state} type="text" id="administrative_area_level_1" name="state" className="form-control" spellCheck="true" placeholder="County" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-lock" />
                                                            <Input type="password"
                                                                   contentEditable="true" className="form-control" id="password" name="password" spellCheck="true" placeholder="Update Password or leave blank" />
                                                        </div>
                                                    </div>
                                                    <h2 className="pb-2">Mini-Bus Details </h2>
                                                    <div>
                                                        <div className="row">
                                                            <div className="form-group col-md-6 col-12">
                                                                <i className="fa fa-bus" />
                                                                <input type="text"
                                                                       contentEditable="true" defaultValue={this.state.user.minibus[0].model} className="form-control" id="model"
                                                                       name="model" spellCheck="true" placeholder="Minibus model" />
                                                            </div>
                                                            <div className="form-group col-md-6 col-12">
                                                                <i className="fa fa-users" />
                                                                <input
                                                                    type="text" defaultValue={this.state.user.minibus[0].capacity}
                                                                    className="form-control" id="capacity" name="capacity" spellCheck="true" placeholder="Minibus Capacity" />
                                                            </div>
                                                        </div>
                                                        <div className="row">
                                                            <div className="form-group col-xl-6 col-12">
                                                                <div className="row">
                                                                    <div className="col-sm-4 col-12">
                                                                        <label className="add-o">With Driver
                                                                            <input type="radio" defaultChecked="checked" value="1" name="type" /><span className="checkmark" /></label>
                                                                    </div>
                                                                    <div className="col-sm-4 col-12">
                                                                        <label className="add-o">Self Drive
                                                                            <input type="radio" defaultChecked="" value="2" name="type" /><span className="checkmark" /></label>
                                                                    </div>
                                                                    <div className="col-sm-4 col-12">
                                                                        <label className="add-o">Both
                                                                            <input type="radio" defaultChecked="" value="3" name="type" /><span className="checkmark" /></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="upload-holder-previews form-group col-xl-12 col-12">
                                                            {
                                                                (this.state.minibus.length) ?
                                                                    <Thumbnail
                                                                            edit={true}
                                                                            //onClick={this.props.onClick}
                                                                            callback={this.ThumbCallback}
                                                                            payload={this.state.minibus}
                                                                            data={this.state.minibus[0].media}
                                                                            style={{width: 200, padding: 10}}
                                                                            viewMode={1}
                                                                            key='path' />
                                                                    : ''
                                                            }
                                                        </div>
                                                        <ImageUploader limit={3} multiple={true} />

                                                    </div>
                                                    <div className="row">
                                                        <div className="col-12 text-center">
                                                            <Button>Update</Button>
                                                        </div>
                                                    </div>
                                                </Form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="modall show" id="cropImagePop" tabIndex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-body">
                                {
                                    (this.state.activeFile) ? <Cropper
                                        ref={cropper => { this.cropper = cropper; }}
                                        src={this.state.activeFile}
                                        style={{height: 400, width: '100%'}}
                                        viewMode={1}
                                        guides={false}
                                        /> : ''

                                }
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" onClick={this.cropImage} data-dismiss="modal" className="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </>
        );
        }
    }
}

export default withRouter(Edit);
