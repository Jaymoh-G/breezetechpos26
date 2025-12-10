import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import useAppStore from "../store/useAppStore";

function SalesPage() {
  const cart = useAppStore((state) => state.cart);
  const addItem = useAppStore((state) => state.addItem);

  return (
    <div>
      <h2 className="mb-3">Quick Sale</h2>
      <Row xs={1} md={2} className="g-3">
        <Col>
          <Card>
            <Card.Body>
              <Card.Title>Items</Card.Title>
              <Button onClick={() => addItem("Coffee")} variant="primary">
                Add Coffee
              </Button>
              <Button onClick={() => addItem("Sandwich")} className="ms-2" variant="secondary">
                Add Sandwich
              </Button>
            </Card.Body>
          </Card>
        </Col>
        <Col>
          <Card>
            <Card.Body>
              <Card.Title>Cart ({cart.length})</Card.Title>
              <ul className="mb-0">
                {cart.map((item, idx) => (
                  <li key={`${item}-${idx}`}>{item}</li>
                ))}
              </ul>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </div>
  );
}

export default SalesPage;

