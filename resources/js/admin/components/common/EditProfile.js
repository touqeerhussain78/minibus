import React, {Component} from 'react';
import PlacesAutocomplete, {
    geocodeByAddress,
    getLatLng,
} from 'react-places-autocomplete';
import Form from 'react-validation/build/form';
import Input from 'react-validation/build/input';
import toastr from 'toastr';
import axios from 'axios';
import Cropper from "react-cropper";
import 'cropperjs/dist/cropper.css';
import $ from "jquery";
import update from 'immutability-helper';
import { Helmet } from 'react-helmet'


class EditProfile extends Component {
    constructor(props){
        super(props);
        this.state = {
            image: '',
            address: window.user.address,
            user: window.user,
            cropResult: window.user.image
        }

    }

    handleSubmit = (event) => {
        event.preventDefault();
        console.log(this);
        const data = new FormData(event.target);
        axios.post('/api/update-profile', data)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                setTimeout(()=> {
                    this.props.history.push('/profile');
                    window.location.reload();
                }, 700);
            })
            .catch((error) => {
                let errors = error.response.data.errors;
                Object.keys(errors).forEach(key=>{
                    toastr.error(errors[key], "Error!");
                });
                setTimeout(()=> {
                    document.body.classList.remove('loading-indicator');
                }, 1000);

            });
    }

    handleChange = (address) => {
        this.setState({ address: address });
    };

    handleFileChange = (event) => {
        var size = event.target.files[0].size;
        if(size <= 5087353){
            $('#cropImagePop').modal('toggle');
            this.setState({ image: event.target.files[0] });
            console.log('file', this.state.image);
            this.setState({ activeFile: URL.createObjectURL(event.target.files[0])});
            
        }else{
            toastr.error('File size is too big, Maximum 5MB allowed','Error');
        }
    }

    cropImage = () =>{
        if (typeof this.cropper.getCroppedCanvas() === 'undefined') {
            return;
        }
        this.setState({
            cropResult: this.cropper.getCroppedCanvas().toDataURL(),
        });
    }


    handleSelect = (address) => {
        let this_ = this;

        this.setState({ address: address });

        this_.setState({
            user: update(this_.state.user, {address: {$set: address}})
        });

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
                            if(addressType == 'locality'){
                                this_.setState({
                                    user: update(this_.state.user, {city: {$set: val}})
                                });
                            }
                            if(addressType == 'administrative_area_level_1'){
                                this_.setState({
                                    user: update(this_.state.user, {state: {$set: val}})
                                });
                            }
                            if(addressType == 'country'){
                                this_.setState({
                                    user: update(this_.state.user, {country: {$set: val}})
                                });
                            }
                            if(addressType == 'zipcode'){
                                this_.setState({
                                    user: update(this_.state.user, {zipcode: {$set: val}})
                                });
                            }

                            console.log(addressType , val);
                            document.getElementById(addressType).value = val;
                        }
                    }
                }

                console.log(result)

            })
    };


    render() {
        return (
            <>
            <Helmet> <title>Minibus - Edit Profile</title> </Helmet>
            
          
            <section id="configuration" className=" add-operator-details search view-cause">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-sm-6 col-12">
                                            <h1 className="pull-left">Edit Profile</h1>
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
                                                            <Input type="text"
                                                                   name="name" className="form-control" spellCheck="true"
                                                                   value={this.state.user.name}
                                                                   placeholder="Username" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-envelope" />
                                                            <Input type="email" disabled
                                                                   name="email" className="form-control" spellCheck="true"
                                                                   value={this.state.user.email}
                                                                   placeholder="Email" />
                                                        </div>

                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-phone" />
                                                            <Input type="number" id="phone-2" name="phone_no"
                                                                   value={this.state.user.phone_no}
                                                                   onKeyDown={ e => ( e.keyCode === 69 || e.keyCode === 190 ) && e.preventDefault() }
                                                                   className="form-control"
                                                                   spellCheck="true" placeholder="Phone # 1" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-phone" />
                                                            <Input type="number" name="phone_no_1"
                                                                   value={this.state.user.phone_no_1}
                                                                   onKeyDown={ e => ( e.keyCode === 69 || e.keyCode === 190 ) && e.preventDefault() }
                                                                   className="form-control" spellCheck="true" placeholder="Phone # 2" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <PlacesAutocomplete
                                                            autoComplete="off"
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
                                                            <Input type="text" id="country"
                                                                   value={this.state.user.country}
                                                                   name="country" className="form-control" spellCheck="true" placeholder="Country" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input type="text" id="locality"
                                                                   value={this.state.user.city}
                                                                   name="city" className="form-control" spellCheck="true" placeholder="City" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input type="text"
                                                                   value={this.state.user.zipcode}
                                                                   id="postal_code" name="zipcode" className="form-control" spellCheck="true" placeholder="zipcode" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <Input type="text"
                                                                   value={this.state.user.state}
                                                                   id="administrative_area_level_1" name="state" className="form-control" spellCheck="true" placeholder="state" />
                                                        </div>
                                                    </div>

                                                    <div className="row">
                                                        <div className="col-12 text-center">
                                                            <button type="submit">Update</button>
                                                            <button onClick={ () => this.props.history.push('/profile')} className="cancel">Cancel</button>
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
                                        aspectRatio={1/1}
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

export default EditProfile;
