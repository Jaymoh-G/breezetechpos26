import Table from "react-bootstrap/Table";

function DataTable({ columns = [], rows = [], renderActions }) {
  return (
    <Table bordered hover responsive className="bg-white shadow-sm">
      <thead className="table-light">
        <tr>
          {columns.map((col) => (
            <th key={col.key || col.accessor}>{col.header}</th>
          ))}
          {renderActions && <th style={{ width: "120px" }}>Actions</th>}
        </tr>
      </thead>
      <tbody>
        {rows.length === 0 && (
          <tr>
            <td colSpan={columns.length + (renderActions ? 1 : 0)} className="text-center">
              No records found
            </td>
          </tr>
        )}
        {rows.map((row) => (
          <tr key={row.id || row.slug || row.sku}>
            {columns.map((col) => (
              <td key={col.key || col.accessor}>
                {typeof col.render === "function" ? col.render(row) : row[col.accessor]}
              </td>
            ))}
            {renderActions && <td>{renderActions(row)}</td>}
          </tr>
        ))}
      </tbody>
    </Table>
  );
}

export default DataTable;

