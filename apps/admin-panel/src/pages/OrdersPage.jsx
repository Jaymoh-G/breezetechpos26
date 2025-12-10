import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockOrders = [
  { id: 101, customer: "Alice", total: 240, status: "pending" },
  { id: 102, customer: "Bob", total: 540, status: "completed" },
];

function OrdersPage() {
  return (
    <div>
      <Header title="Orders" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Order #", accessor: "id" },
              { header: "Customer", accessor: "customer" },
              { header: "Total", render: (r) => `$${r.total}` },
              {
                header: "Status",
                render: (r) => (
                  <Badge bg={r.status === "completed" ? "success" : "warning"}>{r.status}</Badge>
                ),
              },
            ]}
            rows={mockOrders}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default OrdersPage;

