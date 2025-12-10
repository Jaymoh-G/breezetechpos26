import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import useAppStore from "../store/useAppStore";

function HomePage() {
  const setUser = useAppStore((state) => state.setUser);

  return (
    <div>
      <h2 className="mb-3">Welcome to the Store</h2>
      <Card>
        <Card.Body>
          <Card.Title>Discover products and deals.</Card.Title>
          <Card.Text>
            This starter includes routing, global state via Zustand, and React Query ready to wire
            into your APIs.
          </Card.Text>
          <Button onClick={() => setUser({ name: "Guest Shopper", role: "guest" })} variant="dark">
            Continue as Guest
          </Button>
        </Card.Body>
      </Card>
    </div>
  );
}

export default HomePage;

