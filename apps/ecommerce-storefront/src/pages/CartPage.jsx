import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";
import useAppStore from "../store/useAppStore";

function CartPage() {
  const cart = useAppStore((state) => state.cart);

  return (
    <div>
      <h2 className="mb-3">Cart</h2>
      <Card>
        <Card.Body>
          <Card.Title>Your items</Card.Title>
          <ListGroup variant="flush">
            {cart.length === 0 && <ListGroup.Item>No items yet.</ListGroup.Item>}
            {cart.map((item) => (
              <ListGroup.Item key={item.id}>{item.name}</ListGroup.Item>
            ))}
          </ListGroup>
        </Card.Body>
      </Card>
    </div>
  );
}

export default CartPage;

