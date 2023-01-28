import React from "react";
import Column from "../../models/column";

interface TableHeaderProps {
	columns: Column[];
}

const TableHeader = (props: TableHeaderProps) => {
	return (
		<thead>
			<tr>
				{props.columns.map((column) => (
					<th key={column.key}>{column.label}</th>
				))}
			</tr>
		</thead>
	);
};

export default TableHeader;
