import React, {Component} from 'react';
import PlacesAutocomplete, {
    geocodeByAddress,
    getLatLng,
} from 'react-places-autocomplete';
import toastr from 'toastr';
import axios from 'axios';
import { Link,useHistory, withRouter } from 'react-router-dom';
import Cropper from 'react-cropper';
import 'cropperjs/dist/cropper.css';
import { Helmet } from 'react-helmet'

const cropper = React.createRef(null);

class Edit extends Component {

    constructor(props){
        super(props);
        this.state = {
            user: '',
            address: '',
            activeFile: '',
            image: '',
            cropResult: window.base_url + '/administrator/images/Profile_03.png',
        }
        this.fetchUser = this.fetchUser.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleFileChange = this.handleFileChange.bind(this);
        this.cropImage = this.cropImage.bind(this);
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

    handleSubmit(event){
        event.preventDefault();
        const data = new FormData(event.target);
        data.append('id', this.props.id);
        data.append('image', this.state.image);
        axios.post('/api/users/update', data)
            .then((response) => {
                toastr.success(response.data.message, 'Success');
                // setTimeout(()=> {
                //     this.props.history.push('/users');
                // }, 700);
            })
            .catch(error => {
                const result = window._.map(error.response.data.errors, function(value, key) {
                    toastr.error(value[0], 'Error');
                });
                setTimeout(()=> {
                    document.body.classList.remove('loading-indicator');
                }, 1000);

            });
    }

    componentDidMount() {
        this.fetchUser();
    }

    fetchUser(){
        axios.get('/api/users/'+this.props.id)
            .then((response) => {
                 if(response.data.image){
                    this.setState({ cropResult: response.data.image});
                }
                document.getElementById('surname').value = response.data.surname;
                document.getElementById('name').value = response.data.name;
                document.getElementById('email').value = response.data.email;
                document.getElementById('phone_no').value = response.data.phone_no;
                document.getElementById('country').value = response.data.country;
                document.getElementById('locality').value = response.data.city;
                document.getElementById('postal_code').value = response.data.zipcode;
                document.getElementById('administrative_area_level_1').value = response.data.state;
                document.getElementById('address').value = response.data.address;

            })
            .catch((error) => {
                console.log(error);
              //  this.props.history.push('users');
            });
    }

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
        return (
            <>
            <Helmet> <title>Minibus - Edit User</title> </Helmet>
            
            <section id="configuration" className="search view-cause add-operator-details">
                <div className="row">
                    <div className="col-12">
                        <div className="card rounded pad-20">
                            <div className="card-content collapse show">
                                <div className="card-body table-responsive card-dashboard">
                                    <div className="row">
                                        <div className="col-sm-6 col-12">
                                            <h1 className="pull-left">Edit User</h1>
                                        </div>
                                        <div className="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                                            <ol className="breadcrumb">
                                                <li className="breadcrumb-item"><Link to="/dashboard">Home</Link></li>
                                                <li className="breadcrumb-item"><Link to="/users">Users</Link></li>
                                                <li className="breadcrumb-item active"> Edit</li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="add-detail">
                                                <form onSubmit={this.handleSubmit}>
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
                                                            <input type="text"  name="surname" id="surname" className="form-control" spellCheck="true" placeholder="Surname" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-user-circle" />
                                                            <input type="text" id="name" name="name" className="form-control" spellCheck="true" placeholder="Name" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-envelope" />
                                                            <input type="email" disabled="true" id="email" name="email" className="form-control" spellCheck="true" placeholder="Email" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-phone" />
                                                            <input type="number" id="phone_no" name="phone_no" className="form-control" spellCheck="true" placeholder="mobile no" />
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
                                                            <input  type="text" id="country" name="country" className="form-control" spellCheck="true" placeholder="Country" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input  type="text" id="locality" name="city" className="form-control" spellCheck="true" placeholder="City" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input  type="text" id="postal_code" name="zipcode" className="form-control" spellCheck="true" placeholder="zipcode" />
                                                        </div>
                                                        <div className="form-group col-md-6 col-12">
                                                            <i className="fa fa-map-marker" />
                                                            <input  type="text" id="administrative_area_level_1" name="state" className="form-control" spellCheck="true" placeholder="County" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="form-group col-md-12 col-12">
                                                            <i className="fa fa-lock" />
                                                            <input type="password"
                                                                   contentEditable="true" className="form-control" name="password" spellCheck="true" placeholder="Update Password else leave Blank" />
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="col-12 text-center">
                                                            <button>Update</button>
                                                        </div>
                                                    </div>
                                                </form>
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

export default withRouter(Edit);
