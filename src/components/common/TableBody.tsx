import React, { Component } from "react";
import _ from "lodash";
import Column from "../../models/column";

interface TableBodyProps {
	data: any;
	columns: any[];
	idProperty: string;
}

class TableBody extends Component<TableBodyProps> {
	renderCell = (item: any, column: Column) => {
		if (column.content) return column.content(item);

		return _.get(item, column.path);
	};

	createKey = (item: any, column: Column, idProperty: string) => {
		return item[idProperty] + (column.key || column.path);
	};

	render() {
		const { data, columns, idProperty } = this.props;

		return (
			<tbody>
				{data.map((item: any) => (
					<tr key={item[idProperty]}>
						{columns.map((column) => (
							<td key={this.createKey(item, column, idProperty)}>
								{this.renderCell(item, column)}
							</td>
						))}
					</tr>
				))}
			</tbody>
		);
	}
}

export default TableBody;
