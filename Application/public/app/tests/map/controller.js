describe('MapController', function() {
	beforeEach(module('LCP'));

	var $controller;
	var $httpBackend;

	beforeEach(inject(function(_$controller_, $injector){
		// The injector unwraps the underscores (_) from around the parameter names when matching
		$controller = _$controller_;
		$httpBackend = $injector.get('$httpBackend');

		$httpBackend.when('GET', 'app/fixtures/crossings.json')
			.respond( fixture.load('app/fixtures/crossings.json'));
	}));

	function createController() {
		return $controller('MapController');
	}

	describe('initial state', function() {
		it('gateMarkers should be empty', function() {
			var controller = createController();
			expect(controller.gateMarkers.length).to.be.equal(0);
		});
	});

	describe('$scope.init()', function() {
		it('should call loadCrossings', function() {
			var controller = createController();
			var spy = sinon.spy();

			controller.loadCrossings = spy;
			controller.init();

			assert(spy.calledOnce);
		});
	});

	describe('$scope.loadCrossings()', function() {
		it('Should make a http request to get crossings', function() {
			$httpBackend.expectGET('app/fixtures/crossings.json');
			var controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
		});

		it('Should populate the gateMarkers array', function() {
			var controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
			expect(controller.gateMarkers.length).to.be.above(0);
		});
	});


   afterEach(function() {
     $httpBackend.verifyNoOutstandingExpectation();
     $httpBackend.verifyNoOutstandingRequest();
   });
});
