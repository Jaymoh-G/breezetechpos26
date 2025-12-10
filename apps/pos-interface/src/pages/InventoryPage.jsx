import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";

function InventoryPage() {
  const items = [
    { name: "Coffee Beans", stock: 120 },
    { name: "Milk", stock: 45 },
    { name: "Cups", stock: 300 }
  ];

  return (
    <div>
      <h2 className="mb-3">Inventory</h2>
      <Card>
        <Card.Body>
          <Card.Title>Stock Levels</Card.Title>
          <ListGroup variant="flush">
            {items.map((item) => (
              <ListGroup.Item key={item.name} className="d-flex justify-content-between">
                <span>{item.name}</span>
                <span className="fw-semibold">{item.stock}</span>
              </ListGroup.Item>
            ))}
          </ListGroup>
        </Card.Body>
      </Card>
    </div>
  );
}

export default InventoryPage;

