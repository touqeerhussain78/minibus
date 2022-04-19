import React, {Component} from 'react';

class ImageUploader extends Component {

    constructor(props){
        super(props);
        this.state = {
            name: 'files',
            previews : [],
            multiple: false,
            error: '',
        }
        this.handleFileChange = this.handleFileChange.bind(this);
    }

    componentDidMount() {
        if(this.props.multiple){
            this.setState({ name: 'files[]'});
            this.setState({ multiple: true});
        }
    }

    handleFileChange(e){
        if (e.target.files) {

            /* Get files in array form */
            const files = Array.from(e.target.files);
            if(files.length > this.props.limit){
                this.setState({error: 'The maximum number of files you can upload is '+this.props.limit});
                this.files = '';
                this.setState({ previews: []});

            }else{
                /* Map each file to a promise that resolves to an array of image URI's */
                Promise.all(files.map(file => {
                    return (new Promise((resolve,reject) => {
                        const reader = new FileReader();
                        reader.addEventListener('load', (ev) => {
                            resolve(ev.target.result);
                        });
                        reader.addEventListener('error', reject);
                        reader.readAsDataURL(file);
                    }));
                }))
                    .then(images => {
                        /* Once all promises are resolved, update state with image URI array */
                        this.setState({error: ''});
                        this.setState({ previews : images })

                    }, error => {
                        console.error(error);
                    });
            }
        }
     }

    render() {
        return (
            <div className="row">
                <div className="upload-holder form-group col-xl-6 col-12">
                    <a onClick={(e) => this.files.click()}>
                        <img  src={window.base_url + '/administrator/images/upload.png'} />
                    </a>
                    <input type="file"
                           accept={'image/*'}
                           name={this.state.name}
                           multiple = { this.state.multiple }
                           onChange={ (event) => this.handleFileChange(event) }
                           ref={input => this.files = input} style={{display: "none"}}/>
                </div>
                {
                    this.state.error ? <div className="form-group col-xl-12 col-12 alert alert-danger">{this.state.error}</div> : ''
                }
                <div className="upload-holder-previews col-12">
                    {
                        this.state.previews.map((src, key) => {
                            return (<div className="add-img-div"><img key={key} src={src} className="img-fluid" /> <button className="delete-btn" type="button"><i className="fa fa-times-circle"></i></button></div> )
                        })
                    }
                </div>
            </div>
        );
    }
}


export default ImageUploader;
