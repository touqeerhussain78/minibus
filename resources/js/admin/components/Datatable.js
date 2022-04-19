import React, {Component} from 'react';
import $ from "jquery";
$.DataTable = require("datatables.net-bs4");
$.fn.dataTable.ext.errMode = 'none';
// $.fixedColumns = require('datatables.net-fixedcolumns');

export default class DataTable extends Component {
    constructor(props) {
        super(props);
        this.dt = null;
        this.dataTable = null;
        this.state = {
            data : props.data,
            columns : props.columns
        }
    }

    componentDidMount(){
        console.log("LL",this.props.data , this.state.data);
        this.init();
    }

    init(){
        this.$el = $(this.el);

        this.dataTable = this.$el.DataTable({
            // data: this.props.data,
            // columns: this.props.columns,
            // ...this.props.options,
            // order: [[ 0, "desc" ]]
            data: this.state.data,
            columns: this.state.columns,
            ...this.props.options,
            order: [[ 0, "desc" ]]
        });    
    }

    static getDerivedStateFromProps(props, state){
        let update = {};
        if(props.data.length !== state.data.length){
            update.data = props.data;
        }
        if(props.columns.length !== state.columns.length){
            update.columns = props.columns;
        }
        return update;
    }


    componentDidUpdate(prevProps, prevState, snapshot) {
        if(prevProps.data !== this.props.data){
            this.setState({
                data : this.props.data,
                columns : this.props.columns
            })
            this.init();
        }

        this.dataTable.clear();
        //re-populate datatable

        let dataTable = this.dataTable;
        console.log('dataTable', dataTable);
        console.log('this_', dataTable.rows.add(this.state.data).draw());

        // this.$el.DataTable({
        //     data: this.state.data,
        //     columns: this.state.columns,
        //     ...this.props.options,
        //     order: [[ 0, "desc" ]]
        // });                
        // this.dataTable.draw();        
    
    }

    componentWillUnmount() {
        this.dataTable.destroy(true);
    }

    search(value){
        this.dataTable.search(value).draw();
    };

    render() {
        return <table className={this.props.class} ref={el => (this.el = el)} />;
    }
}
