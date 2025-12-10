import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import useAppStore from "../store/useAppStore";

const products = [
  { id: 1, name: "POS Terminal", price: "$899" },
  { id: 2, name: "Barcode Scanner", price: "$199" },
  { id: 3, name: "Receipt Printer", price: "$149" }
];

function CatalogPage() {
  const addToCart = useAppStore((state) => state.addToCart);

  return (
    <div>
      <h2 className="mb-3">Catalog</h2>
      <Row xs={1} md={2} lg={3} className="g-3">
        {products.map((product) => (
          <Col key={product.id}>
            <Card>
              <Card.Body>
                <Card.Title>{product.name}</Card.Title>
                <Card.Text className="text-muted">{product.price}</Card.Text>
                <Button onClick={() => addToCart(product)} variant="primary">
                  Add to Cart
                </Button>
              </Card.Body>
            </Card>
          </Col>
        ))}
      </Row>
    </div>
  );
}

export default CatalogPage;

