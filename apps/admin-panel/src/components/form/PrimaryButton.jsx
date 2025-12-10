import Button from "react-bootstrap/Button";

function PrimaryButton({ children, ...props }) {
  return (
    <Button variant="primary" {...props}>
      {children}
    </Button>
  );
}

export default PrimaryButton;

