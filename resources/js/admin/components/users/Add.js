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
import { Helmet } from 'react-helmet'

const required = (value, props) => {
    if (!value || (props.isCheckable && !props.checked)) {
        return <span className="form-error is-visible">The Field is Required</span>;
    }
};

const email = (value) => {
    if (!isEmail(value)) {
        return <span className="form-error is-visible">{value} is not a valid email.</span>;
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

class Add extends Component {

    constructor(props){
        super(props);
        this.state = {
            address: '',
            activeFile: '',
            image: '',
            cropResult: window.base_url + '/administrator/images/Profile_03.png',
        }

        this.handleSelect = this.handleSelect.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleFileChange = this.handleFileChange.bind(this);
        this.cropImage = this.cropImage.bind(this);
    }

    handleSubmit(event){
        event.preventDefault();
        console.log(this);
        const data = new FormData(event.target);
        data.append('image', this.state.image);
        axios.post('/api/users/store', data)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                    this.props.history.push('/users');
                }, 700);
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
            console.log('state',this.state);
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
        return (
            <>
            <Helmet> <title>Minibus - Add User</title> </Helmet>
            
            <section id="configuration" className="search view-cause add-operator-details">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-sm-6 col-12">
                                            <h1 className="pull-left">Add User</h1>
                                        </div>
                                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/users">Users</Link></li>
                                                <li className="breadcrumb-item active"> Add</li>
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
                                                            <Input type="text" validations={[required]} name="surname" key="Surname" className="form-control" spellCheck="true" placeholder="Sur Name" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-user-circle" />
                                                            <Input type="text" validations={[required]} name="name" key="name" className="form-control" spellCheck="true" placeholder="Name" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-envelope" />
                                                            <Input type="email" validations={[required, email]} name="email" key="email" className="form-control" spellCheck="true" placeholder="Email" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-phone" />
                                                            <Input type="number" id="phone-2" name="phone_no" onKeyDown={ e => ( e.keyCode === 69 || e.keyCode === 190 ) && e.preventDefault() } key="phone_no" className="form-control" spellCheck="true" placeholder="mobile no" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <PlacesAutocomplete
                                                            validations={[required, isEqual]}
                                                            value={this.state.address}
                                                            onChange={this.handleChange}
                                                            onSelect={this.handleSelect}
                                                        >
                                                            {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                                                                <div className="col-md-12 form-group">
                                                                    <i className="fa fa-map-marker" />
                                                                    <input
                                                                        {...getInputProps({
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
                                                            <input validations={[required]} type="text" id="country" name="country" key="country" className="form-control" spellCheck="true" placeholder="Country" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input validations={[required]} type="text" id="locality" name="city" key="city" className="form-control" spellCheck="true" placeholder="City" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input validations={[required]} type="text" id="postal_code" name="zipcode" key="zipcode" className="form-control" spellCheck="true" placeholder="zipcode" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input validations={[required]} type="text" id="administrative_area_level_1" name="state" key="state" className="form-control" spellCheck="true" placeholder="County" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-lock" />
                                                            <Input type="password"
                                                                   validations={[required, isEqual]}
                                                                   contentEditable="true" className="form-control" name="password" key="password" spellCheck="true" placeholder="Password" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-lock" />
                                                            <Input type="password"
                                                                   validations={[required, isEqual]}
                                                                   contentEditable="true" className="form-control" name="confirm" spellCheck="true" placeholder="Confirm Password" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="col-12 text-center">
                                                            <Button>Add</Button>
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
            </section>
       </>
        );
    }
}

export default withRouter(Add);
