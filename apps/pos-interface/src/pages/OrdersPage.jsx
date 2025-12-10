import Card from "react-bootstrap/Card";
import Table from "react-bootstrap/Table";

function OrdersPage() {
  const orders = [
    { id: "POS-001", total: "$24.00", status: "Paid" },
    { id: "POS-002", total: "$13.50", status: "Pending" }
  ];

  return (
    <div>
      <h2 className="mb-3">Orders</h2>
      <Card>
        <Card.Body>
          <Card.Title>Recent Orders</Card.Title>
          <Table striped hover responsive className="mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {orders.map((order) => (
                <tr key={order.id}>
                  <td>{order.id}</td>
                  <td>{order.total}</td>
                  <td>{order.status}</td>
                </tr>
              ))}
            </tbody>
          </Table>
        </Card.Body>
      </Card>
    </div>
  );
}

export default OrdersPage;

