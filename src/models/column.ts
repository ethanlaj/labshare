interface ColumnBasics {
	label?: string;
}

interface ColumnWithContent extends ColumnBasics {
	key: string;
	content: Function;
	path?: never;
}

interface ColumnWithPath extends ColumnBasics {
	path: string;
	key?: never;
	content?: never;
}

type Column = ColumnWithContent | ColumnWithPath;
export default Column;
