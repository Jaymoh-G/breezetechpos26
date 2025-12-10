import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockSales = [
  { id: 201, branch: "Main", total: 180, status: "completed" },
  { id: 202, branch: "Downtown", total: 340, status: "pending" },
];

function SalesPage() {
  return (
    <div>
      <Header title="Sales" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Sale #", accessor: "id" },
              { header: "Branch", accessor: "branch" },
              { header: "Total", render: (r) => `$${r.total}` },
              {
                header: "Status",
                render: (r) => (
                  <Badge bg={r.status === "completed" ? "success" : "warning"}>{r.status}</Badge>
                ),
              },
            ]}
            rows={mockSales}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default SalesPage;

