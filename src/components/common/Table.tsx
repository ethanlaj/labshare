import React from "react";
import TableHeader from "./TableHeader";
import TableBody from "./TableBody";
import Column from "../../models/column";

interface TableProps {
	columns: Column[];
	data: any[];
	idProperty: string;
}

const Table = ({ columns, data, idProperty }: TableProps) => {
	return (
		<table className="table table-hover">
			<TableHeader columns={columns} />
			<TableBody columns={columns} data={data} idProperty={idProperty} />
		</table>
	);
};

export default Table;
