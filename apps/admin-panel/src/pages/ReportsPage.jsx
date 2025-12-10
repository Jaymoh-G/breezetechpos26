import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";

function ReportsPage() {
  const reports = ["Sales", "Inventory", "Staff Performance"];

  return (
    <div>
      <h2 className="mb-3">Reports</h2>
      <Card>
        <Card.Body>
          <Card.Title>Available Reports</Card.Title>
          <ListGroup variant="flush">
            {reports.map((report) => (
              <ListGroup.Item key={report}>{report}</ListGroup.Item>
            ))}
          </ListGroup>
        </Card.Body>
      </Card>
    </div>
  );
}

export default ReportsPage;

